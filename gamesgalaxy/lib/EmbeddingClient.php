<?php

namespace gamesgalaxy\lib;

require_once __DIR__ . "/exception/EmbeddingException.php";
require_once __DIR__ . "/exception/EmbeddingUnavailableException.php";

use gamesgalaxy\lib\exception\EmbeddingException;
use gamesgalaxy\lib\exception\EmbeddingUnavailableException;

class EmbeddingClient
{
    private array $_config;

    public function __construct(?array $config = null)
    {
        $configured_provider = strtolower($this->_read_config_value($config, 'GG_EMBEDDING_PROVIDER', ''));
        $configured_endpoint = $this->_read_config_value($config, 'GG_EMBEDDING_ENDPOINT', '');
        $provider = $configured_provider !== '' ? $configured_provider : $this->_detect_provider($configured_endpoint);
        $default_endpoint = $provider === 'openai' ? 'https://api.openai.com/v1/embeddings' : 'http://localhost:11434/api/embed';
        $default_model = $provider === 'openai' ? 'text-embedding-3-small' : 'nomic-embed-text';
        $default_dimensions = $provider === 'openai' ? '1536' : '0';

        $this->_config = [
            'provider' => $provider,
            'endpoint' => $configured_endpoint !== '' ? $configured_endpoint : $default_endpoint,
            'api_key' => $this->_read_config_value($config, 'GG_EMBEDDING_API_KEY', ''),
            'model' => $this->_read_config_value($config, 'GG_EMBEDDING_MODEL', $default_model),
            'dimensions' => (int) $this->_read_config_value($config, 'GG_EMBEDDING_DIMENSIONS', $default_dimensions),
            'timeout' => (int) $this->_read_config_value($config, 'GG_EMBEDDING_TIMEOUT', '10')
        ];
    }

    public function create_embedding(string $text): array
    {
        $text = trim($text);

        if ($text === '')
        {
            error_log('EmbeddingClient: Leerer Text für Embedding erhalten.');
            throw new EmbeddingException('Für ein Embedding wird Text benötigt.');
        }

        if (!$this->is_configured())
        {
            error_log('EmbeddingClient: Embedding-Anbieter ist nicht konfiguriert.');
            throw new EmbeddingUnavailableException('Embedding-Anbieter ist nicht konfiguriert.');
        }

        if (!function_exists('curl_init'))
        {
            error_log('EmbeddingClient: PHP-cURL ist nicht verfügbar.');
            throw new EmbeddingUnavailableException('PHP-cURL ist nicht verfügbar.');
        }

        $payload = $this->_build_payload($text);

        $response = $this->_post_json($this->_config['endpoint'], $payload);
        $embedding = $this->_extract_embedding($response);

        if (empty($embedding))
        {
            error_log('EmbeddingClient: Embedding-Antwort enthält keinen Vektor.');
            throw new EmbeddingException('Embedding-Antwort enthält keinen Vektor.');
        }

        error_log('EmbeddingClient: Embedding erfolgreich erstellt.');

        return $embedding;
    }

    public function get_dimensions(): int
    {
        return $this->_config['dimensions'];
    }

    public function is_configured(): bool
    {
        if ($this->_config['provider'] === 'openai')
        {
            return $this->_config['endpoint'] !== '' && $this->_config['api_key'] !== '';
        }

        return $this->_config['endpoint'] !== '' && $this->_config['model'] !== '';
    }

    private function _post_json(string $endpoint, array $payload): array
    {
        $curl = curl_init($endpoint);
        $headers = [
            'Content-Type: application/json'
        ];

        if ($this->_config['api_key'] !== '')
        {
            $authorization_type = $this->_config['provider'] === 'openai' ? 'Bearer ' : '';
            $headers[] = 'Authorization: ' . $authorization_type . $this->_config['api_key'];
        }

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => $this->_config['timeout']
        ]);

        $body = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        $curl_error = curl_error($curl);
        curl_close($curl);

        if ($body === false || $status_code >= 500 || $status_code === 0)
        {
            error_log('EmbeddingClient: Anbieter nicht erreichbar. HTTP-Status: ' . $status_code);
            throw new EmbeddingUnavailableException('Embedding-Anbieter ist nicht erreichbar.');
        }

        if ($status_code >= 400)
        {
            error_log('EmbeddingClient: Anbieter lehnt Anfrage ab. HTTP-Status: ' . $status_code);
            throw new EmbeddingException('Embedding-Anfrage wurde abgelehnt.');
        }

        $decoded = json_decode($body, true);

        if (!is_array($decoded))
        {
            error_log('EmbeddingClient: Ungültige JSON-Antwort. cURL-Fehler: ' . $curl_error);
            throw new EmbeddingException('Embedding-Antwort ist kein gültiges JSON.');
        }

        return $decoded;
    }

    private function _extract_embedding(array $response): array
    {
        $embedding = $response['data'][0]['embedding']
            ?? $response['embeddings'][0]
            ?? $response['embedding']
            ?? null;

        if (!is_array($embedding))
        {
            return [];
        }

        return array_map(static function ($value)
        {
            return (float) $value;
        }, $embedding);
    }

    private function _build_payload(string $text): array
    {
        if ($this->_config['provider'] === 'ollama')
        {
            if (str_ends_with($this->_config['endpoint'], '/api/embeddings'))
            {
                return [
                    'model' => $this->_config['model'],
                    'prompt' => $text
                ];
            }

            $payload = [
                'model' => $this->_config['model'],
                'input' => $text
            ];

            if ($this->_config['dimensions'] > 0)
            {
                $payload['dimensions'] = $this->_config['dimensions'];
            }

            return $payload;
        }

        return [
            'model' => $this->_config['model'],
            'input' => $text
        ];
    }

    private function _detect_provider(string $endpoint): string
    {
        if (str_contains($endpoint, 'openai.com'))
        {
            return 'openai';
        }

        return 'ollama';
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
