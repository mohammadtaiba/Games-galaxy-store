<?php

require_once __DIR__ . "/../gamesgalaxy/lib/SearchQueryParser.php";
require_once __DIR__ . "/../gamesgalaxy/lib/SearchQueryInterpreter.php";
require_once __DIR__ . "/../gamesgalaxy/lib/EmbeddingClient.php";
require_once __DIR__ . "/../gamesgalaxy/lib/ElasticsearchClient.php";
require_once __DIR__ . "/../gamesgalaxy/model/AdvancedSearchModel.php";
require_once __DIR__ . "/../gamesgalaxy/lib/exception/EmbeddingUnavailableException.php";
require_once __DIR__ . "/../gamesgalaxy/lib/exception/ElasticsearchUnavailableException.php";
require_once __DIR__ . "/../gamesgalaxy/lib/exception/SearchQueryInterpreterException.php";

use gamesgalaxy\lib\ElasticsearchClient;
use gamesgalaxy\lib\EmbeddingClient;
use gamesgalaxy\lib\exception\ElasticsearchUnavailableException;
use gamesgalaxy\lib\exception\EmbeddingUnavailableException;
use gamesgalaxy\lib\exception\SearchQueryInterpreterException;
use gamesgalaxy\lib\SearchQueryInterpreter;
use gamesgalaxy\lib\SearchQueryParser;
use gamesgalaxy\Model\AdvancedSearchModel;
use gamesgalaxy\Model\SearchModel;

class AdvancedSearchTestAssertionFailed extends Exception
{
}

class FailingEmbeddingClient extends EmbeddingClient
{
    public function is_configured(): bool
    {
        return true;
    }

    public function create_embedding(string $text): array
    {
        throw new EmbeddingUnavailableException('Embedding-Testfehler');
    }
}

class SuccessfulEmbeddingClient extends EmbeddingClient
{
    public function is_configured(): bool
    {
        return true;
    }

    public function create_embedding(string $text): array
    {
        return [0.1, 0.2, 0.3];
    }
}

class SuccessfulQueryInterpreter extends SearchQueryInterpreter
{
    public bool $used = false;

    public function is_configured(): bool
    {
        return true;
    }

    public function interpret(string $query): array
    {
        $this->used = true;

        return [
            'raw_query' => $query,
            'normalized_query' => mb_strtolower($query, 'UTF-8'),
            'semantic_query' => '',
            'filters' => [
                'price' => [
                    'operator' => 'lte',
                    'value' => 25.0
                ],
                'genres' => [],
                'platforms' => ['Steam'],
                'is_online' => null,
                'is_offline' => null
            ]
        ];
    }
}

class FailingQueryInterpreter extends SearchQueryInterpreter
{
    public function is_configured(): bool
    {
        return true;
    }

    public function interpret(string $query): array
    {
        throw new SearchQueryInterpreterException('Interpreter-Testfehler');
    }
}

class RecordingSearchQueryParser extends SearchQueryParser
{
    public bool $used = false;

    public function parse(string $query): array
    {
        $this->used = true;

        return parent::parse($query);
    }
}

class FailingElasticsearchClient extends ElasticsearchClient
{
    public function search(array $parsed_query, array $embedding): array
    {
        throw new ElasticsearchUnavailableException('Elasticsearch-Testfehler');
    }
}

class EmptyElasticsearchClient extends ElasticsearchClient
{
    public array $last_embedding = [];
    public array $last_parsed_query = [];

    public function search(array $parsed_query, array $embedding): array
    {
        $this->last_parsed_query = $parsed_query;
        $this->last_embedding = $embedding;

        return [];
    }
}

class FakeSearchModel extends SearchModel
{
    public string $last_query = '';

    public function __construct()
    {
    }

    public function match_and_read(string $search_string)
    {
        $this->last_query = $search_string;

        return [
            [
                'game_id' => 99,
                'game_name' => 'Fallback Game',
                'game_platform' => 'Steam',
                'game_price' => '9,99',
                'game_description' => 'Fallback result'
            ]
        ];
    }
}

function assert_true(bool $condition, string $message): void
{
    if (!$condition)
    {
        throw new AdvancedSearchTestAssertionFailed($message);
    }
}

function assert_same($expected, $actual, string $message): void
{
    if ($expected !== $actual)
    {
        throw new AdvancedSearchTestAssertionFailed($message . ' Erwartet: ' . var_export($expected, true) . ', erhalten: ' . var_export($actual, true));
    }
}

function filter_exists(array $filters, string $type, string $field, $expected_value): bool
{
    foreach ($filters as $filter)
    {
        if (!isset($filter[$type][$field]))
        {
            continue;
        }

        if ($filter[$type][$field] === $expected_value)
        {
            return true;
        }
    }

    return false;
}

function range_filter_exists(array $filters, string $field, string $operator, float $expected_value): bool
{
    foreach ($filters as $filter)
    {
        if (($filter['range'][$field][$operator] ?? null) === $expected_value)
        {
            return true;
        }
    }

    return false;
}

function test_parser_extracts_exact_filters(): void
{
    $parser = new SearchQueryParser();
    $parsed = $parser->parse('Shooter unter 50 Euro, online und offline spielbar');
    $filters = $parsed['filters'];

    assert_same('lte', $filters['price']['operator'], 'Preisoperator muss lte sein.');
    assert_same(50.0, $filters['price']['value'], 'Preiswert muss 50 sein.');
    assert_same(['Shooter'], $filters['genres'], 'Genre muss exakt erkannt werden.');
    assert_same(true, $filters['is_online'], 'Online-Filter muss gesetzt sein.');
    assert_same(true, $filters['is_offline'], 'Offline-Filter muss gesetzt sein.');
}

function test_parser_extracts_platform_and_decimal_price(): void
{
    $parser = new SearchQueryParser();
    $parsed = $parser->parse('RPG auf Steam bis 29,99 Euro');
    $filters = $parsed['filters'];

    assert_same(['RPG'], $filters['genres'], 'RPG muss erkannt werden.');
    assert_same(['Steam'], $filters['platforms'], 'Steam muss erkannt werden.');
    assert_same(29.99, $filters['price']['value'], 'Dezimalpreis mit Komma muss erkannt werden.');
}

function test_parser_accepts_euro_symbol(): void
{
    $parser = new SearchQueryParser();
    $parsed = $parser->parse('Shooter unter 50' . html_entity_decode('&euro;', ENT_QUOTES, 'UTF-8'));
    $filters = $parsed['filters'];

    assert_same('lte', $filters['price']['operator'], 'Euro-Symbol muss als Preisangabe erkannt werden.');
    assert_same(50.0, $filters['price']['value'], 'Preiswert mit Euro-Symbol muss erkannt werden.');
}

function test_parser_handles_natural_shooter_request(): void
{
    $parser = new SearchQueryParser();
    $parsed = $parser->parse('ich möchte shooter-spiele unter 50' . html_entity_decode('&euro;', ENT_QUOTES, 'UTF-8'));
    $filters = $parsed['filters'];

    assert_same(['Shooter'], $filters['genres'], 'Shooter muss auch in shooter-spiele erkannt werden.');
    assert_same('lte', $filters['price']['operator'], 'Preisoperator muss aus natürlicher Anfrage erkannt werden.');
    assert_same(50.0, $filters['price']['value'], 'Preiswert muss aus natürlicher Anfrage erkannt werden.');
    assert_true($parsed['semantic_query'] !== '', 'Der technische Parser darf natuerliche Satzreste nicht sprachabhaengig per Stopwortliste entfernen.');
}

function test_parser_handles_shooting_synonym(): void
{
    $parser = new SearchQueryParser();
    $parsed = $parser->parse('gib mir alle shooting spiele');
    $filters = $parsed['filters'];

    assert_same(['Shooter'], $filters['genres'], 'Shooting muss als Shooter-Synonym erkannt werden.');
    assert_true($parsed['semantic_query'] !== '', 'Generische Anfragewoerter bleiben im Parser-Fallback als semantischer Rest erhalten.');
}

function test_parser_handles_natural_steam_price_request(): void
{
    $parser = new SearchQueryParser();
    $parsed = $parser->parse('ich möchte steam-spiele die unter 25' . html_entity_decode('&euro;', ENT_QUOTES, 'UTF-8') . ' kosten');
    $filters = $parsed['filters'];

    assert_same(['Steam'], $filters['platforms'], 'Steam muss in natÃ¼rlicher Anfrage erkannt werden.');
    assert_same('lte', $filters['price']['operator'], 'Preisoperator muss aus natÃ¼rlicher Steam-Anfrage erkannt werden.');
    assert_same(25.0, $filters['price']['value'], 'Preiswert muss aus natÃ¼rlicher Steam-Anfrage erkannt werden.');
    assert_true($parsed['semantic_query'] !== '', 'Satzfuellung wird nicht mehr durch eine sprachabhaengige Stopwortliste bereinigt.');
}

function test_elasticsearch_payload_contains_exact_filters(): void
{
    $parser = new SearchQueryParser();
    $parsed = $parser->parse('Shooter unter 50 Euro auf Steam online und offline');
    $client = new ElasticsearchClient(['GG_ELASTICSEARCH_URL' => 'http://localhost:9200']);
    $payload = $client->build_search_payload($parsed, [0.1, 0.2, 0.3]);
    $filters = $payload['query']['script_score']['query']['bool']['filter'];

    assert_true(range_filter_exists($filters, 'game_price_amount', 'lte', 50.0), 'Preisfilter muss als Range-Filter enthalten sein.');
    assert_true(filter_exists($filters, 'term', 'genres', 'Shooter'), 'Genre muss als Term-Filter enthalten sein.');
    assert_true(filter_exists($filters, 'term', 'game_platform', 'Steam'), 'Plattform muss als Term-Filter enthalten sein.');
    assert_true(filter_exists($filters, 'term', 'game_is_online', true), 'Online muss als Term-Filter enthalten sein.');
    assert_true(filter_exists($filters, 'term', 'game_is_offline', true), 'Offline muss als Term-Filter enthalten sein.');
}

function test_elasticsearch_text_query_is_optional_when_exact_filters_exist(): void
{
    $client = new ElasticsearchClient(['GG_ELASTICSEARCH_URL' => 'http://localhost:9200']);
    $payload = $client->build_search_payload([
        'raw_query' => 'ich möchte steam-spiele die unter 25 Euro kosten',
        'semantic_query' => 'die kosten',
        'filters' => [
            'price' => [
                'operator' => 'lte',
                'value' => 25.0
            ],
            'genres' => [],
            'platforms' => ['Steam'],
            'is_online' => null,
            'is_offline' => null
        ]
    ], [0.1, 0.2, 0.3]);

    $bool_query = $payload['query']['script_score']['query']['bool'];
    $filters = $bool_query['filter'];

    assert_true(isset($bool_query['should']), 'Semantischer Text darf bei exakten Filtern nur optional sein.');
    assert_same(0, $bool_query['minimum_should_match'], 'Optionale Textsuche darf Treffer mit passenden Filtern nicht blockieren.');
    assert_true(!isset($bool_query['must']), 'Semantischer Text darf bei exakten Filtern keine Pflichtbedingung sein.');
    assert_true(range_filter_exists($filters, 'game_price_amount', 'lte', 25.0), 'Preisfilter muss trotz optionalem Text erhalten bleiben.');
    assert_true(filter_exists($filters, 'term', 'game_platform', 'Steam'), 'Plattformfilter muss trotz optionalem Text erhalten bleiben.');
}

function test_query_interpreter_can_extract_multilingual_intent(): void
{
    $query_interpreter = new SuccessfulQueryInterpreter();
    $elasticsearch_client = new EmptyElasticsearchClient(['GG_ELASTICSEARCH_URL' => 'http://localhost:9200']);
    $model = new AdvancedSearchModel(
        new SearchQueryParser(),
        new SuccessfulEmbeddingClient(),
        $elasticsearch_client,
        new FakeSearchModel(),
        null,
        $query_interpreter
    );

    $result = $model->advanced_search('I want steam games below 25 euros');
    $filters = $elasticsearch_client->last_parsed_query['filters'];

    assert_same(true, $query_interpreter->used, 'Konfigurierter Query-Interpreter muss vor dem Parser genutzt werden.');
    assert_same(['Steam'], $filters['platforms'], 'Interpreter muss Plattform als exakten Filter liefern.');
    assert_same('lte', $filters['price']['operator'], 'Interpreter muss englische Preisabsicht in lte umformen.');
    assert_same(25.0, $filters['price']['value'], 'Interpreter muss Preiswert normalisieren.');
    assert_same(false, $result['meta']['fallback_used'], 'Interpreter-Nutzung darf keinen Standardsuche-Fallback ausloesen.');
    assert_same('elasticsearch_vector', $result['meta']['source'], 'Interpretierte Anfrage muss weiter die Vektorsuche nutzen.');
}

function test_query_interpreter_failure_uses_parser_fallback(): void
{
    $parser = new RecordingSearchQueryParser();
    $elasticsearch_client = new EmptyElasticsearchClient(['GG_ELASTICSEARCH_URL' => 'http://localhost:9200']);
    $model = new AdvancedSearchModel(
        $parser,
        new SuccessfulEmbeddingClient(),
        $elasticsearch_client,
        new FakeSearchModel(),
        null,
        new FailingQueryInterpreter()
    );

    $result = $model->advanced_search('RPG auf Steam bis 29,99 Euro');
    $filters = $elasticsearch_client->last_parsed_query['filters'];

    assert_same(true, $parser->used, 'Bei Interpreter-Fehler muss der technische Parser genutzt werden.');
    assert_same(['RPG'], $filters['genres'], 'Parser-Fallback muss Genre weiterhin erkennen.');
    assert_same(['Steam'], $filters['platforms'], 'Parser-Fallback muss Plattform weiterhin erkennen.');
    assert_same(29.99, $filters['price']['value'], 'Parser-Fallback muss Preis weiterhin erkennen.');
    assert_same(false, $result['meta']['fallback_used'], 'Interpreter-Fehler darf nicht direkt die Standardsuche erzwingen.');
}

function test_ollama_embedding_is_configured_without_api_key(): void
{
    $embedding_client = new EmbeddingClient([
        'GG_EMBEDDING_PROVIDER' => 'ollama',
        'GG_EMBEDDING_ENDPOINT' => 'http://localhost:11434/api/embed',
        'GG_EMBEDDING_MODEL' => 'nomic-embed-text',
        'GG_EMBEDDING_API_KEY' => ''
    ]);

    assert_same(true, $embedding_client->is_configured(), 'Ollama-Embeddings müssen ohne API-Key konfiguriert sein.');
}

function test_elasticsearch_document_contains_embedding_vector(): void
{
    $client = new ElasticsearchClient(['GG_ELASTICSEARCH_URL' => 'http://localhost:9200']);
    $document = $client->build_document([
        'game_id' => 1,
        'game_name' => 'Vector Game',
        'game_description' => 'Semantic search test',
        'game_platform' => 'Steam',
        'game_price' => '19,99',
        'game_is_online' => true,
        'game_is_offline' => true,
        'genres' => ['Shooter']
    ], [0.1, 0.2, 0.3]);

    assert_same([0.1, 0.2, 0.3], $document['embedding'], 'Index-Dokument muss den Embedding-Vektor enthalten.');
}

function test_embedding_failure_uses_standard_search_fallback(): void
{
    $fallback_search_model = new FakeSearchModel();
    $model = new AdvancedSearchModel(
        new SearchQueryParser(),
        new FailingEmbeddingClient(),
        new ElasticsearchClient(['GG_ELASTICSEARCH_URL' => 'http://localhost:9200']),
        $fallback_search_model
    );

    $result = $model->advanced_search('Shooter unter 50 Euro');

    assert_same(true, $result['meta']['fallback_used'], 'Embedding-Ausfall muss Fallback aktivieren.');
    assert_same('standard', $result['meta']['source'], 'Fallback-Quelle muss Standardsuche sein.');
    assert_same('Shooter unter 50 Euro', $fallback_search_model->last_query, 'Fallback muss Originalanfrage verwenden.');
    assert_same('Fallback Game', $result['games'][0]['game_name'], 'Fallback-Ergebnis muss zurückgegeben werden.');
}

function test_elasticsearch_failure_uses_standard_search_fallback(): void
{
    $fallback_search_model = new FakeSearchModel();
    $model = new AdvancedSearchModel(
        new SearchQueryParser(),
        new SuccessfulEmbeddingClient(),
        new FailingElasticsearchClient(['GG_ELASTICSEARCH_URL' => 'http://localhost:9200']),
        $fallback_search_model
    );

    $result = $model->advanced_search('RPG auf Steam');

    assert_same(true, $result['meta']['fallback_used'], 'Elasticsearch-Ausfall muss Fallback aktivieren.');
    assert_same('standard', $result['meta']['source'], 'Fallback-Quelle muss Standardsuche sein.');
    assert_same('RPG auf Steam', $fallback_search_model->last_query, 'Fallback muss Originalanfrage verwenden.');
}

function test_missing_embedding_config_uses_elasticsearch_fulltext_without_fallback(): void
{
    $fallback_search_model = new FakeSearchModel();
    $elasticsearch_client = new EmptyElasticsearchClient(['GG_ELASTICSEARCH_URL' => 'http://localhost:9200']);
    $model = new AdvancedSearchModel(
        new SearchQueryParser(),
        new EmbeddingClient([
            'GG_EMBEDDING_PROVIDER' => 'openai',
            'GG_EMBEDDING_ENDPOINT' => 'https://api.openai.com/v1/embeddings',
            'GG_EMBEDDING_API_KEY' => ''
        ]),
        $elasticsearch_client,
        $fallback_search_model
    );

    $result = $model->advanced_search('Shooter unter 50 Euro');

    assert_same(false, $result['meta']['fallback_used'], 'Fehlende Embedding-Konfiguration darf keinen Standardsuche-Fallback erzwingen.');
    assert_same('elasticsearch_fulltext', $result['meta']['source'], 'Ohne Embedding muss Elasticsearch-Volltext genutzt werden.');
    assert_same([], $elasticsearch_client->last_embedding, 'Ohne Embedding-Konfiguration darf kein Vektor übergeben werden.');
    assert_same('', $fallback_search_model->last_query, 'Die Standardsuche darf in diesem Fall nicht aufgerufen werden.');
}

$tests = [
    'test_parser_extracts_exact_filters',
    'test_parser_extracts_platform_and_decimal_price',
    'test_parser_accepts_euro_symbol',
    'test_parser_handles_natural_shooter_request',
    'test_parser_handles_shooting_synonym',
    'test_parser_handles_natural_steam_price_request',
    'test_elasticsearch_payload_contains_exact_filters',
    'test_elasticsearch_text_query_is_optional_when_exact_filters_exist',
    'test_query_interpreter_can_extract_multilingual_intent',
    'test_query_interpreter_failure_uses_parser_fallback',
    'test_ollama_embedding_is_configured_without_api_key',
    'test_elasticsearch_document_contains_embedding_vector',
    'test_embedding_failure_uses_standard_search_fallback',
    'test_elasticsearch_failure_uses_standard_search_fallback',
    'test_missing_embedding_config_uses_elasticsearch_fulltext_without_fallback'
];

foreach ($tests as $test)
{
    $test();
    echo $test . " OK\n";
}

echo "Alle Advanced-Search-Tests erfolgreich.\n";
