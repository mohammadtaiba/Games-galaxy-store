<?php

namespace gamesgalaxy\lib;

require_once __DIR__ . "/exception/ElasticsearchException.php";
require_once __DIR__ . "/exception/ElasticsearchUnavailableException.php";

use gamesgalaxy\lib\exception\ElasticsearchException;
use gamesgalaxy\lib\exception\ElasticsearchUnavailableException;

class ElasticsearchClient
{
    private array $_config;

    public function __construct(?array $config = null)
    {
        $this->_config = [
            'url' => rtrim($this->_read_config_value($config, 'GG_ELASTICSEARCH_URL', ''), '/'),
            'index' => $this->_read_config_value($config, 'GG_ELASTICSEARCH_INDEX', 'games_galaxy_games'),
            'username' => $this->_read_config_value($config, 'GG_ELASTICSEARCH_USERNAME', ''),
            'password' => $this->_read_config_value($config, 'GG_ELASTICSEARCH_PASSWORD', ''),
            'api_key' => $this->_read_config_value($config, 'GG_ELASTICSEARCH_API_KEY', ''),
            'timeout' => (int) $this->_read_config_value($config, 'GG_ELASTICSEARCH_TIMEOUT', '10')
        ];
    }

    public function create_index(int $embedding_dimensions): void
    {
        if (!$this->is_configured())
        {
            error_log('ElasticsearchClient: Elasticsearch ist nicht konfiguriert.');
            throw new ElasticsearchUnavailableException('Elasticsearch ist nicht konfiguriert.');
        }

        $properties = [
            'game_id' => ['type' => 'integer'],
            'game_name' => [
                'type' => 'text',
                'fields' => [
                    'keyword' => ['type' => 'keyword']
                ]
            ],
            'game_description' => ['type' => 'text'],
            'game_platform' => ['type' => 'keyword'],
            'genres' => ['type' => 'keyword'],
            'game_price_amount' => ['type' => 'scaled_float', 'scaling_factor' => 100],
            'game_is_online' => ['type' => 'boolean'],
            'game_is_offline' => ['type' => 'boolean'],
            'search_text' => ['type' => 'text']
        ];

        if ($embedding_dimensions > 0)
        {
            $properties['embedding'] = [
                'type' => 'dense_vector',
                'dims' => $embedding_dimensions,
                'index' => true,
                'similarity' => 'cosine'
            ];
        }

        $payload = [
            'mappings' => [
                'properties' => $properties
            ]
        ];

        try
        {
            $this->_request('PUT', '/' . rawurlencode($this->_config['index']), $payload);
            error_log('ElasticsearchClient: Index wurde erstellt.');
        }
        catch (ElasticsearchException $exception)
        {
            if (str_contains($exception->getMessage(), 'resource_already_exists_exception'))
            {
                error_log('ElasticsearchClient: Index existiert bereits.');
                return;
            }

            throw $exception;
        }
    }

    public function search(array $parsed_query, array $embedding): array
    {
        if (!$this->is_configured())
        {
            error_log('ElasticsearchClient: Elasticsearch ist nicht konfiguriert.');
            throw new ElasticsearchUnavailableException('Elasticsearch ist nicht konfiguriert.');
        }

        $payload = $this->build_search_payload($parsed_query, $embedding);
        $response = $this->_request('POST', '/' . rawurlencode($this->_config['index']) . '/_search', $payload);
        $hits = $response['hits']['hits'] ?? [];
        $game_ids = [];

        foreach ($hits as $hit)
        {
            $game_id = $hit['_source']['game_id'] ?? null;

            if ($game_id !== null)
            {
                $game_ids[] = (int) $game_id;
            }
        }

        error_log('ElasticsearchClient: Suche lieferte ' . count($game_ids) . ' Treffer.');

        return $game_ids;
    }

    public function index_game(array $game, array $embedding): void
    {
        if (!$this->is_configured())
        {
            error_log('ElasticsearchClient: Elasticsearch ist nicht konfiguriert.');
            throw new ElasticsearchUnavailableException('Elasticsearch ist nicht konfiguriert.');
        }

        $document = $this->build_document($game, $embedding);
        $game_id = (int) $document['game_id'];
        $this->_request('PUT', '/' . rawurlencode($this->_config['index']) . '/_doc/' . $game_id, $document);
        error_log('ElasticsearchClient: Spiel indexiert. game_id=' . $game_id);
    }

    public function delete_index(): void
    {
        if (!$this->is_configured())
        {
            error_log('ElasticsearchClient: Elasticsearch ist nicht konfiguriert.');
            throw new ElasticsearchUnavailableException('Elasticsearch ist nicht konfiguriert.');
        }

        try
        {
            $this->_request('DELETE', '/' . rawurlencode($this->_config['index']));
            error_log('ElasticsearchClient: Index wurde gelöscht.');
        }
        catch (ElasticsearchException $exception)
        {
            if (str_contains($exception->getMessage(), 'index_not_found_exception'))
            {
                error_log('ElasticsearchClient: Index existierte vor Reset nicht.');
                return;
            }

            throw $exception;
        }
    }

    public function build_search_payload(array $parsed_query, array $embedding): array
    {
        $filters = $this->_build_filters($parsed_query['filters'] ?? []);
        $semantic_query = trim($parsed_query['semantic_query'] ?? $parsed_query['raw_query'] ?? '');
        $has_filters = !empty($filters);
        $has_embedding = !empty($embedding);

        $bool_query = [
            'filter' => $filters
        ];

        if ($semantic_query !== '')
        {
            $text_query = [
                'multi_match' => [
                    'query' => $semantic_query,
                    'fields' => [
                        'game_name^3',
                        'game_description',
                        'search_text',
                        'genres'
                    ],
                    'fuzziness' => 'AUTO'
                ]
            ];

            if ($has_filters || $has_embedding)
            {
                $bool_query['should'] = [
                    $text_query
                ];
                $bool_query['minimum_should_match'] = 0;
            }
            else
            {
                $bool_query['must'] = [
                    $text_query
                ];
            }
        }

        if (empty($bool_query['must']) && empty($bool_query['should']) && empty($bool_query['filter']))
        {
            $bool_query['must'] = [
                ['match_all' => (object) []]
            ];
        }

        $base_query = [
            'bool' => $bool_query
        ];

        if ($has_embedding)
        {
            $query = [
                'script_score' => [
                    'query' => $base_query,
                    'script' => [
                        'source' => "cosineSimilarity(params.query_vector, 'embedding') + 1.0 + _score",
                        'params' => [
                            'query_vector' => array_values($embedding)
                        ]
                    ]
                ]
            ];
        }
        else
        {
            $query = $base_query;
        }

        return [
            'size' => 20,
            'query' => $query
        ];
    }

    public function build_document(array $game, array $embedding): array
    {
        $genres = $game['genres'] ?? $game['category_names'] ?? [];

        if (is_string($genres))
        {
            $genres = array_filter(array_map('trim', explode(',', $genres)));
        }

        $document = [
            'game_id' => (int) $game['game_id'],
            'game_name' => (string) $game['game_name'],
            'game_description' => (string) ($game['game_description'] ?? ''),
            'game_platform' => (string) $game['game_platform'],
            'genres' => array_values($genres),
            'game_price_amount' => (float) ($game['game_price_amount'] ?? $this->_parse_price($game['game_price'] ?? '0')),
            'game_is_online' => (bool) ($game['game_is_online'] ?? false),
            'game_is_offline' => (bool) ($game['game_is_offline'] ?? true),
            'search_text' => trim(implode(' ', [
                $game['game_name'] ?? '',
                $game['game_description'] ?? '',
                $game['game_platform'] ?? '',
                implode(' ', $genres)
            ]))
        ];

        if (!empty($embedding))
        {
            $document['embedding'] = array_values($embedding);
        }

        return $document;
    }

    public function is_configured(): bool
    {
        return $this->_config['url'] !== '';
    }

    private function _build_filters(array $filters): array
    {
        $query_filters = [];
        $price_filter = $filters['price'] ?? null;

        if ($price_filter !== null)
        {
            $operator = $price_filter['operator'] ?? 'eq';
            $value = (float) ($price_filter['value'] ?? 0);

            if ($operator === 'eq')
            {
                $query_filters[] = [
                    'range' => [
                        'game_price_amount' => [
                            'gte' => $value,
                            'lte' => $value
                        ]
                    ]
                ];
            }
            else
            {
                $query_filters[] = [
                    'range' => [
                        'game_price_amount' => [
                            $operator => $value
                        ]
                    ]
                ];
            }
        }

        foreach ($filters['genres'] ?? [] as $genre)
        {
            $query_filters[] = [
                'term' => [
                    'genres' => $genre
                ]
            ];
        }

        foreach ($filters['platforms'] ?? [] as $platform)
        {
            $query_filters[] = [
                'term' => [
                    'game_platform' => $platform
                ]
            ];
        }

        if (($filters['is_online'] ?? null) === true)
        {
            $query_filters[] = [
                'term' => [
                    'game_is_online' => true
                ]
            ];
        }

        if (($filters['is_offline'] ?? null) === true)
        {
            $query_filters[] = [
                'term' => [
                    'game_is_offline' => true
                ]
            ];
        }

        return $query_filters;
    }

    private function _request(string $method, string $path, ?array $payload = null): array
    {
        if (!function_exists('curl_init'))
        {
            error_log('ElasticsearchClient: PHP-cURL ist nicht verfügbar.');
            throw new ElasticsearchUnavailableException('PHP-cURL ist nicht verfügbar.');
        }

        $curl = curl_init($this->_config['url'] . $path);
        $headers = ['Content-Type: application/json'];

        if ($this->_config['api_key'] !== '')
        {
            $headers[] = 'Authorization: ApiKey ' . $this->_config['api_key'];
        }

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => $this->_config['timeout']
        ]);

        if ($this->_config['username'] !== '' || $this->_config['password'] !== '')
        {
            curl_setopt($curl, CURLOPT_USERPWD, $this->_config['username'] . ':' . $this->_config['password']);
        }

        if ($payload !== null)
        {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        }

        $body = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        $curl_error = curl_error($curl);
        curl_close($curl);

        if ($body === false || $status_code >= 500 || $status_code === 0)
        {
            error_log('ElasticsearchClient: Elasticsearch nicht erreichbar. HTTP-Status: ' . $status_code);
            throw new ElasticsearchUnavailableException('Elasticsearch ist nicht erreichbar.');
        }

        $decoded = json_decode($body, true);

        if ($status_code >= 400)
        {
            $reason = $decoded['error']['type'] ?? $decoded['error']['reason'] ?? 'Elasticsearch-Fehler';
            error_log('ElasticsearchClient: Anfrage fehlgeschlagen. HTTP-Status: ' . $status_code . ', Grund: ' . $reason);
            throw new ElasticsearchException((string) $reason);
        }

        if (!is_array($decoded))
        {
            error_log('ElasticsearchClient: Ungültige JSON-Antwort. cURL-Fehler: ' . $curl_error);
            throw new ElasticsearchException('Elasticsearch-Antwort ist kein gültiges JSON.');
        }

        return $decoded;
    }

    private function _parse_price(string $price): float
    {
        return (float) str_replace(',', '.', $price);
    }

    private function _read_config_value(?array $config, string $key, string $default): string
    {
        if ($config !== null && array_key_exists($key, $config))
        {
            return (string) $config[$key];
        }

        $value = getenv($key);

        if ($value !== false)
        {
            return (string) $value;
        }

        if (isset($_ENV[$key]))
        {
            return (string) $_ENV[$key];
        }

        return $default;
    }
}
