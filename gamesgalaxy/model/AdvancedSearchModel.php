<?php

namespace gamesgalaxy\Model;

require_once __DIR__ . "/../model/Model.php";
require_once __DIR__ . "/../model/SearchModel.php";
require_once __DIR__ . "/../lib/DatabaseConnection.php";
require_once __DIR__ . "/../lib/SearchQueryParser.php";
require_once __DIR__ . "/../lib/SearchQueryInterpreter.php";
require_once __DIR__ . "/../lib/EmbeddingClient.php";
require_once __DIR__ . "/../lib/ElasticsearchClient.php";
require_once __DIR__ . "/../lib/exception/SearchException.php";
require_once __DIR__ . "/../lib/exception/SearchQueryParserException.php";
require_once __DIR__ . "/../lib/exception/SearchQueryInterpreterException.php";
require_once __DIR__ . "/../lib/exception/EmbeddingException.php";
require_once __DIR__ . "/../lib/exception/ElasticsearchException.php";
require_once __DIR__ . "/../lib/exception/SearchIndexException.php";

use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;
use gamesgalaxy\lib\ElasticsearchClient;
use gamesgalaxy\lib\EmbeddingClient;
use gamesgalaxy\lib\exception\ElasticsearchException;
use gamesgalaxy\lib\exception\EmbeddingException;
use gamesgalaxy\lib\exception\SearchIndexException;
use gamesgalaxy\lib\exception\SearchQueryInterpreterException;
use gamesgalaxy\lib\exception\SearchQueryParserException;
use gamesgalaxy\lib\SearchQueryInterpreter;
use gamesgalaxy\lib\SearchQueryParser;

class AdvancedSearchModel extends Model
{
    private ?\mysqli $_db;
    private SearchQueryParser $_parser;
    private SearchQueryInterpreter $_query_interpreter;
    private EmbeddingClient $_embedding_client;
    private ElasticsearchClient $_elasticsearch_client;
    private SearchModel $_fallback_search_model;

    public function __construct(
        ?SearchQueryParser $parser = null,
        ?EmbeddingClient $embedding_client = null,
        ?ElasticsearchClient $elasticsearch_client = null,
        ?SearchModel $fallback_search_model = null,
        ?\mysqli $db = null,
        ?SearchQueryInterpreter $query_interpreter = null
    )
    {
        $this->_parser = $parser ?? new SearchQueryParser();
        $this->_query_interpreter = $query_interpreter ?? new SearchQueryInterpreter();
        $this->_embedding_client = $embedding_client ?? new EmbeddingClient();
        $this->_elasticsearch_client = $elasticsearch_client ?? new ElasticsearchClient();
        $this->_fallback_search_model = $fallback_search_model ?? new SearchModel();
        $this->_db = $db;
    }

    public function advanced_search(string $query): array
    {
        try
        {
            $parsed_query = $this->_parse_query($query);
            $embedding_text = $parsed_query['semantic_query'] !== '' ? $parsed_query['semantic_query'] : $parsed_query['raw_query'];
            $embedding = $this->_create_optional_embedding($embedding_text);
            $game_ids = $this->_elasticsearch_client->search($parsed_query, $embedding);
            $games = $this->_read_games_by_ids($game_ids);
            $source = empty($embedding) ? 'elasticsearch_fulltext' : 'elasticsearch_vector';

            error_log('AdvancedSearchModel: Erweiterte Suche erfolgreich abgeschlossen.');

            return $this->_build_result($games, $parsed_query, false, '', $source);
        }
        catch (SearchQueryParserException $exception)
        {
            error_log('AdvancedSearchModel: Parserfehler: ' . $exception->getMessage());

            return $this->_build_result([], [
                'raw_query' => $query,
                'semantic_query' => '',
                'filters' => []
            ], false, $exception->getMessage(), 'parser');
        }
        catch (EmbeddingException | ElasticsearchException $exception)
        {
            error_log('AdvancedSearchModel: Erweiterte Suche nicht verfügbar, Fallback wird genutzt. Grund: ' . $exception->getMessage());

            return $this->_fallback_to_standard_search($query, $exception->getMessage());
        }
        catch (\Throwable $exception)
        {
            error_log('AdvancedSearchModel: Unerwarteter Fehler, Fallback wird genutzt. Grund: ' . $exception->getMessage());

            return $this->_fallback_to_standard_search($query, 'Unerwarteter Fehler in der erweiterten Suche.');
        }
    }

    public function index_all_games(bool $reset_index = false): int
    {
        try
        {
            $games = $this->_read_games_for_index();
            $indexed_games = [];
            $embedding_dimensions = 0;

            foreach ($games as $game)
            {
                $embedding = $this->_embedding_client->create_embedding($this->_build_embedding_text($game));

                if (empty($embedding))
                {
                    throw new SearchIndexException('Für die Vektorsuche wurde kein Embedding erzeugt.');
                }

                if ($embedding_dimensions === 0)
                {
                    $embedding_dimensions = count($embedding);
                }

                $indexed_games[] = [
                    'game' => $game,
                    'embedding' => $embedding
                ];
            }

            if ($reset_index)
            {
                $this->_elasticsearch_client->delete_index();
            }

            $this->_elasticsearch_client->create_index($embedding_dimensions);
            $indexed_count = 0;

            foreach ($indexed_games as $indexed_game)
            {
                $game = $indexed_game['game'];
                $embedding = $indexed_game['embedding'];
                $this->_elasticsearch_client->index_game($game, $embedding);
                $this->_mark_game_as_indexed((int) $game['game_id']);
                $indexed_count++;
            }

            error_log('AdvancedSearchModel: Indexierung abgeschlossen. Anzahl: ' . $indexed_count);

            return $indexed_count;
        }
        catch (\Throwable $exception)
        {
            error_log('AdvancedSearchModel: Indexierung fehlgeschlagen. Grund: ' . $exception->getMessage());
            throw new SearchIndexException('Die erweiterte Suche konnte nicht indexiert werden.', 0, $exception);
        }
    }

    public function match_and_read(string $search_string)
    {
        return $this->advanced_search($search_string);
    }

    public function create()
    {
    }

    public function read()
    {
    }

    public function read_all()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }

    public function delete_all()
    {
    }

    private function _fallback_to_standard_search(string $query, string $reason): array
    {
        try
        {
            $games = $this->_fallback_search_model->match_and_read($query);
            error_log('AdvancedSearchModel: Standardsuche als Fallback erfolgreich.');

            return $this->_build_result($games, [
                'raw_query' => $query,
                'semantic_query' => $query,
                'filters' => []
            ], true, $reason, 'standard');
        }
        catch (\Throwable $exception)
        {
            error_log('AdvancedSearchModel: Fallback auf Standardsuche fehlgeschlagen. Grund: ' . $exception->getMessage());

            return $this->_build_result([], [
                'raw_query' => $query,
                'semantic_query' => $query,
                'filters' => []
            ], true, 'Fallback fehlgeschlagen.', 'standard');
        }
    }

    private function _parse_query(string $query): array
    {
        if ($this->_query_interpreter->is_configured())
        {
            try
            {
                return $this->_query_interpreter->interpret($query);
            }
            catch (SearchQueryInterpreterException $exception)
            {
                error_log('AdvancedSearchModel: Query-Interpreter nicht nutzbar, Parser-Fallback wird verwendet. Grund: ' . $exception->getMessage());
            }
        }

        return $this->_parser->parse($query);
    }

    private function _create_optional_embedding(string $text): array
    {
        if (!$this->_embedding_client->is_configured())
        {
            error_log('AdvancedSearchModel: Kein Embedding-Anbieter konfiguriert, Elasticsearch-Volltextsuche wird ohne Vektor genutzt.');
            return [];
        }

        return $this->_embedding_client->create_embedding($text);
    }

    private function _build_result(array $games, array $parsed_query, bool $fallback_used, string $fallback_reason, string $source): array
    {
        return [
            'games' => $games,
            'meta' => [
                'raw_query' => $parsed_query['raw_query'] ?? '',
                'semantic_query' => $parsed_query['semantic_query'] ?? '',
                'filters' => $parsed_query['filters'] ?? [],
                'fallback_used' => $fallback_used,
                'fallback_reason' => $fallback_reason,
                'source' => $source
            ]
        ];
    }

    private function _read_games_by_ids(array $game_ids): array
    {
        if (empty($game_ids))
        {
            return [];
        }

        $db = $this->_get_db();
        $placeholders = implode(',', array_fill(0, count($game_ids), '?'));
        $query = "SELECT g.*,
                    GROUP_CONCAT(
                        DISTINCT CONCAT_WS(', ',
                            CASE WHEN c.Strategie = 1 THEN 'Strategie' ELSE NULL END,
                            CASE WHEN c.Action = 1 THEN 'Action' ELSE NULL END,
                            CASE WHEN c.Shooter = 1 THEN 'Shooter' ELSE NULL END,
                            CASE WHEN c.RPG = 1 THEN 'RPG' ELSE NULL END,
                            CASE WHEN c.Simulation = 1 THEN 'Simulation' ELSE NULL END
                        )
                    ) AS category_names
                    FROM game g
                    LEFT JOIN category c ON g.game_id = c.game_id
                    WHERE g.game_id IN ($placeholders)
                    GROUP BY g.game_id";

        $stmt = $db->prepare($query);

        if (!$stmt)
        {
            error_log('AdvancedSearchModel: Prepare für Ergebnisdaten fehlgeschlagen: ' . $db->error);
            return [];
        }

        $types = str_repeat('i', count($game_ids));
        $bind_values = [$types];

        foreach ($game_ids as $index => $game_id)
        {
            $game_ids[$index] = (int) $game_id;
            $bind_values[] = &$game_ids[$index];
        }

        call_user_func_array([$stmt, 'bind_param'], $bind_values);
        $stmt->execute();
        $result = $stmt->get_result();
        $games_by_id = [];

        while ($row = $result->fetch_assoc())
        {
            $row['category_names'] = $row['category_names'] !== null ? explode(', ', $row['category_names']) : [];
            $games_by_id[(int) $row['game_id']] = $row;
        }

        $stmt->close();
        $ordered_games = [];

        foreach ($game_ids as $game_id)
        {
            if (isset($games_by_id[$game_id]))
            {
                $ordered_games[] = $games_by_id[$game_id];
            }
        }

        return $ordered_games;
    }

    private function _read_games_for_index(): array
    {
        $db = $this->_get_db();
        $query = "SELECT g.game_id,
                    g.game_name,
                    g.game_description,
                    g.game_platform,
                    g.game_price,
                    g.game_price_amount,
                    g.game_is_online,
                    g.game_is_offline,
                    GROUP_CONCAT(
                        DISTINCT CONCAT_WS(', ',
                            CASE WHEN c.Strategie = 1 THEN 'Strategie' ELSE NULL END,
                            CASE WHEN c.Action = 1 THEN 'Action' ELSE NULL END,
                            CASE WHEN c.Shooter = 1 THEN 'Shooter' ELSE NULL END,
                            CASE WHEN c.RPG = 1 THEN 'RPG' ELSE NULL END,
                            CASE WHEN c.Simulation = 1 THEN 'Simulation' ELSE NULL END
                        )
                    ) AS category_names
                    FROM game g
                    LEFT JOIN category c ON g.game_id = c.game_id
                    GROUP BY g.game_id";

        $result = $db->query($query);

        if (!$result)
        {
            error_log('AdvancedSearchModel: Lesen der Indexdaten fehlgeschlagen: ' . $db->error);
            throw new SearchIndexException('Indexdaten konnten nicht aus MySQL gelesen werden.');
        }

        $games = [];

        while ($row = $result->fetch_assoc())
        {
            $row['genres'] = $row['category_names'] !== null ? explode(', ', $row['category_names']) : [];
            $games[] = $row;
        }

        return $games;
    }

    private function _mark_game_as_indexed(int $game_id): void
    {
        $db = $this->_get_db();
        $stmt = $db->prepare("UPDATE game SET game_search_indexed_at = NOW() WHERE game_id = ?");

        if (!$stmt)
        {
            error_log('AdvancedSearchModel: Prepare für Index-Zeitstempel fehlgeschlagen: ' . $db->error);
            return;
        }

        $stmt->bind_param('i', $game_id);
        $stmt->execute();
        $stmt->close();
    }

    private function _build_embedding_text(array $game): string
    {
        $genres = $game['genres'] ?? [];

        return trim(implode(' ', [
            $game['game_name'] ?? '',
            $game['game_description'] ?? '',
            $game['game_platform'] ?? '',
            implode(' ', $genres)
        ]));
    }

    private function _get_db(): \mysqli
    {
        if ($this->_db === null)
        {
            $this->_db = DatabaseConnection::get_instance();
        }

        return $this->_db;
    }
}
