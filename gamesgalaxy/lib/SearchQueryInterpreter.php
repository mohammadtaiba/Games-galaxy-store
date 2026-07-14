<?php

namespace gamesgalaxy\lib;

require_once __DIR__ . "/exception/SearchQueryInterpreterException.php";
require_once __DIR__ . "/exception/SearchQueryInterpreterUnavailableException.php";

use gamesgalaxy\lib\exception\SearchQueryInterpreterException;
use gamesgalaxy\lib\exception\SearchQueryInterpreterUnavailableException;

class SearchQueryInterpreter
{
    private array $_config;
    private array $_allowed_genres = [
        'Strategie',
        'Action',
        'Shooter',
        'RPG',
        'Simulation'
    ];
    private array $_allowed_platforms = [
        'Steam',
        'Epic Games',
        'Battle.net'
    ];

    public function __construct(?array $config = null)
    {
        $this->_config = [
            'enabled' => $this->_read_config_value($config, 'GG_QUERY_INTERPRETER_ENABLED', '0'),
            'endpoint' => $this->_read_config_value($config, 'GG_QUERY_INTERPRETER_ENDPOINT', 'http://localhost:11434/api/chat'),
            'model' => $this->_read_config_value($config, 'GG_QUERY_INTERPRETER_MODEL', ''),
            'timeout' => (int) $this->_read_config_value($config, 'GG_QUERY_INTERPRETER_TIMEOUT', '15')
        ];
    }

    public function is_configured(): bool
    {
        return $this->_is_enabled($this->_config['enabled'])
            && $this->_config['endpoint'] !== ''
            && $this->_config['model'] !== '';
    }

    public function interpret(string $query): array
    {
        $query = trim($query);

        if ($query === '')
        {
            error_log('SearchQueryInterpreter: Leere Suchanfrage erhalten.');
            throw new SearchQueryInterpreterException('Die Suchanfrage darf nicht leer sein.');
        }

        if (!$this->is_configured())
        {
            error_log('SearchQueryInterpreter: Query-Interpreter ist nicht konfiguriert.');
            throw new SearchQueryInterpreterUnavailableException('Query-Interpreter ist nicht konfiguriert.');
        }

        if (!function_exists('curl_init'))
        {
            error_log('SearchQueryInterpreter: PHP-cURL ist nicht verfuegbar.');
            throw new SearchQueryInterpreterUnavailableException('PHP-cURL ist nicht verfuegbar.');
        }

        $payload = $this->_build_payload($query);
        $response = $this->_post_json($this->_config['endpoint'], $payload);
        $content = $this->_extract_content($response);
        $data = $this->_decode_json_content($content);
        $interpreted_query = $this->_normalize_interpretation($data, $query);

        error_log('SearchQueryInterpreter: Suchanfrage erfolgreich interpretiert.');

        return $interpreted_query;
    }

    private function _build_payload(string $query): array
    {
        return [
            'model' => $this->_config['model'],
            'stream' => false,
            'format' => 'json',
            'options' => [
                'temperature' => 0
            ],
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $this->_build_system_prompt()
                ],
                [
                    'role' => 'user',
                    'content' => $query
                ]
            ]
        ];
    }

    private function _build_system_prompt(): string
    {
        return implode("\n", [
            'You convert natural language game-shop search queries into strict JSON.',
            'The user may write in any language.',
            'Return only JSON. Do not return markdown. Do not generate SQL.',
            'Only use these genres: Strategie, Action, Shooter, RPG, Simulation.',
            'Only use these platforms: Steam, Epic Games, Battle.net.',
            'Treat price, genre, platform, online and offline as exact filters only when the user clearly asks for them.',
            'Use null when a filter is unknown.',
            'Use price.operator lte for below/under/max, gte for above/from/min, eq for exactly.',
            'semantic_query is the remaining meaningful game preference after exact filters, for example "open world fantasy".',
            'If the query contains only exact filters, semantic_query must be an empty string.',
            'JSON shape:',
            '{"semantic_query":"","filters":{"price":null,"genres":[],"platforms":[],"is_online":null,"is_offline":null}}'
        ]);
    }

    private function _post_json(string $endpoint, array $payload): array
    {
        $curl = curl_init($endpoint);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => $this->_config['timeout']
        ]);

        $body = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        $curl_error = curl_error($curl);
        curl_close($curl);

        if ($body === false || $status_code >= 500 || $status_code === 0)
        {
            error_log('SearchQueryInterpreter: Ollama nicht erreichbar. HTTP-Status: ' . $status_code);
            throw new SearchQueryInterpreterUnavailableException('Query-Interpreter ist nicht erreichbar.');
        }

        if ($status_code >= 400)
        {
            error_log('SearchQueryInterpreter: Ollama lehnt Anfrage ab. HTTP-Status: ' . $status_code);
            throw new SearchQueryInterpreterException('Query-Interpreter-Anfrage wurde abgelehnt.');
        }

        $decoded = json_decode($body, true);

        if (!is_array($decoded))
        {
            error_log('SearchQueryInterpreter: Ungueltige JSON-Antwort. cURL-Fehler: ' . $curl_error);
            throw new SearchQueryInterpreterException('Query-Interpreter-Antwort ist kein gueltiges JSON.');
        }

        return $decoded;
    }

    private function _extract_content(array $response): string
    {
        $content = $response['message']['content']
            ?? $response['response']
            ?? '';

        $content = trim((string) $content);

        if ($content === '')
        {
            error_log('SearchQueryInterpreter: Antwort enthaelt keinen Inhalt.');
            throw new SearchQueryInterpreterException('Query-Interpreter-Antwort enthaelt keinen Inhalt.');
        }

        return $content;
    }

    private function _decode_json_content(string $content): array
    {
        $content = trim($content);
        $content = preg_replace('/^```(?:json)?\s*/i', '', $content);
        $content = preg_replace('/\s*```$/', '', $content);
        $decoded = json_decode($content, true);

        if (is_array($decoded))
        {
            return $decoded;
        }

        $start = strpos($content, '{');
        $end = strrpos($content, '}');

        if ($start === false || $end === false || $end <= $start)
        {
            error_log('SearchQueryInterpreter: Keine JSON-Struktur in Modellantwort gefunden.');
            throw new SearchQueryInterpreterException('Query-Interpreter-Antwort enthaelt kein JSON.');
        }

        $decoded = json_decode(substr($content, $start, $end - $start + 1), true);

        if (!is_array($decoded))
        {
            error_log('SearchQueryInterpreter: Modellantwort enthaelt ungueltiges JSON.');
            throw new SearchQueryInterpreterException('Query-Interpreter-Antwort enthaelt ungueltiges JSON.');
        }

        return $decoded;
    }

    private function _normalize_interpretation(array $data, string $raw_query): array
    {
        $filters = is_array($data['filters'] ?? null) ? $data['filters'] : $data;

        return [
            'raw_query' => $raw_query,
            'normalized_query' => mb_strtolower($raw_query, 'UTF-8'),
            'semantic_query' => trim((string) ($data['semantic_query'] ?? '')),
            'filters' => [
                'price' => $this->_normalize_price_filter($filters['price'] ?? null),
                'genres' => $this->_normalize_allowed_values($filters['genres'] ?? [], $this->_allowed_genres),
                'platforms' => $this->_normalize_allowed_values($filters['platforms'] ?? [], $this->_allowed_platforms),
                'is_online' => $this->_normalize_nullable_bool($filters['is_online'] ?? null),
                'is_offline' => $this->_normalize_nullable_bool($filters['is_offline'] ?? null)
            ]
        ];
    }

    private function _normalize_price_filter($price_filter): ?array
    {
        if (!is_array($price_filter))
        {
            return null;
        }

        $operator = $this->_normalize_price_operator((string) ($price_filter['operator'] ?? ''));
        $value = $price_filter['value'] ?? $price_filter['amount'] ?? null;

        if (!in_array($operator, ['lte', 'gte', 'eq'], true) || !is_numeric($value))
        {
            return null;
        }

        return [
            'operator' => $operator,
            'value' => (float) $value
        ];
    }

    private function _normalize_price_operator(string $operator): string
    {
        $operator = strtolower(trim($operator));

        $operator_aliases = [
            'lte' => 'lte',
            'lt' => 'lte',
            'max' => 'lte',
            'maximum' => 'lte',
            'under' => 'lte',
            'below' => 'lte',
            'less_than' => 'lte',
            'gte' => 'gte',
            'gt' => 'gte',
            'min' => 'gte',
            'minimum' => 'gte',
            'from' => 'gte',
            'above' => 'gte',
            'more_than' => 'gte',
            'eq' => 'eq',
            'exact' => 'eq',
            'exactly' => 'eq'
        ];

        return $operator_aliases[$operator] ?? $operator;
    }

    private function _normalize_allowed_values($values, array $allowed_values): array
    {
        if (is_string($values))
        {
            $values = [$values];
        }

        if (!is_array($values))
        {
            return [];
        }

        $normalized_values = [];

        foreach ($values as $value)
        {
            $matched_value = $this->_match_allowed_value((string) $value, $allowed_values);

            if ($matched_value !== null)
            {
                $normalized_values[$matched_value] = $matched_value;
            }
        }

        return array_values($normalized_values);
    }

    private function _match_allowed_value(string $value, array $allowed_values): ?string
    {
        $normalized_value = mb_strtolower(trim($value), 'UTF-8');

        foreach ($allowed_values as $allowed_value)
        {
            if ($normalized_value === mb_strtolower($allowed_value, 'UTF-8'))
            {
                return $allowed_value;
            }
        }

        return null;
    }

    private function _normalize_nullable_bool($value): ?bool
    {
        if ($value === null)
        {
            return null;
        }

        if (is_bool($value))
        {
            return $value;
        }

        if (is_string($value))
        {
            $normalized_value = strtolower(trim($value));

            if (in_array($normalized_value, ['true', '1', 'yes', 'ja'], true))
            {
                return true;
            }

            if (in_array($normalized_value, ['false', '0', 'no', 'nein'], true))
            {
                return false;
            }
        }

        return null;
    }

    private function _is_enabled(string $value): bool
    {
        return in_array(strtolower(trim($value)), ['1', 'true', 'yes', 'on'], true);
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
