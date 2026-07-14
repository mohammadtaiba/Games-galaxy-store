<?php

namespace gamesgalaxy\lib;

require_once __DIR__ . "/exception/SearchQueryParserException.php";

use gamesgalaxy\lib\exception\SearchQueryParserException;

class SearchQueryParser
{
    private array $_genre_aliases = [
        'strategie' => 'Strategie',
        'strategy' => 'Strategie',
        'action' => 'Action',
        'shooter' => 'Shooter',
        'shooting' => 'Shooter',
        'shootern' => 'Shooter',
        'rpg' => 'RPG',
        'rollenspiel' => 'RPG',
        'simulation' => 'Simulation',
        'simulator' => 'Simulation'
    ];

    private array $_platform_aliases = [
        'steam' => 'Steam',
        'epic games' => 'Epic Games',
        'epic' => 'Epic Games',
        'battle.net' => 'Battle.net',
        'battlenet' => 'Battle.net',
        'battle net' => 'Battle.net',
        'blizzard' => 'Battle.net'
    ];

    public function parse(string $query): array
    {
        $query = trim($query);

        if ($query === '')
        {
            error_log('SearchQueryParser: Leere Suchanfrage erhalten.');
            throw new SearchQueryParserException('Die Suchanfrage darf nicht leer sein.');
        }

        $normalized_query = $this->_normalize_query($query);
        $filters = [
            'price' => null,
            'genres' => [],
            'platforms' => [],
            'is_online' => null,
            'is_offline' => null
        ];

        $filters['price'] = $this->_extract_price_filter($normalized_query);
        $filters['genres'] = $this->_extract_alias_matches($normalized_query, $this->_genre_aliases);
        $filters['platforms'] = $this->_extract_alias_matches($normalized_query, $this->_platform_aliases);
        $filters['is_online'] = $this->_contains_word($normalized_query, 'online') ? true : null;
        $filters['is_offline'] = $this->_contains_word($normalized_query, 'offline') ? true : null;

        $semantic_query = $this->_build_semantic_query($normalized_query, $filters);

        error_log('SearchQueryParser: Suchanfrage erfolgreich geparst.');

        return [
            'raw_query' => $query,
            'normalized_query' => $normalized_query,
            'semantic_query' => $semantic_query,
            'filters' => $filters
        ];
    }

    private function _normalize_query(string $query): string
    {
        $query = mb_strtolower($query, 'UTF-8');
        $query = str_replace('€', ' euro ', $query);
        $query = preg_replace('/[-_\/]+/u', ' ', $query);
        $query = preg_replace('/(?<!\d),(?!\d)/u', ' ', $query);
        $query = preg_replace('/[?!;:()\[\]{}"„“]+/u', ' ', $query);
        $query = preg_replace('/\s+/', ' ', $query);

        return trim($query);
    }

    private function _extract_price_filter(string $query): ?array
    {
        $price_pattern = '/\b(?<operator>unter|bis|maximal|höchstens|kleiner als|weniger als|über|ab|mindestens|größer als|mehr als|genau|für)\s+(?<amount>\d+(?:[\.,]\d{1,2})?)\s*(?:euro|eur)?\b/u';

        if (!preg_match($price_pattern, $query, $matches))
        {
            return null;
        }

        $operator = $matches['operator'];
        $amount = (float) str_replace(',', '.', $matches['amount']);

        if (in_array($operator, ['unter', 'bis', 'maximal', 'höchstens', 'kleiner als', 'weniger als'], true))
        {
            return [
                'operator' => 'lte',
                'value' => $amount
            ];
        }

        if (in_array($operator, ['über', 'ab', 'mindestens', 'größer als', 'mehr als'], true))
        {
            return [
                'operator' => 'gte',
                'value' => $amount
            ];
        }

        return [
            'operator' => 'eq',
            'value' => $amount
        ];
    }

    private function _extract_alias_matches(string $query, array $aliases): array
    {
        $matches = [];

        foreach ($aliases as $alias => $value)
        {
            if ($this->_contains_phrase($query, $alias))
            {
                $matches[$value] = $value;
            }
        }

        return array_values($matches);
    }

    private function _build_semantic_query(string $query, array $filters): string
    {
        $semantic_query = $query;
        $price_filter = $filters['price'];

        if ($price_filter !== null)
        {
            $semantic_query = preg_replace('/\b(unter|bis|maximal|höchstens|kleiner als|weniger als|über|ab|mindestens|größer als|mehr als|genau|für)\s+\d+(?:[\.,]\d{1,2})?\s*(?:euro|eur)?\b/u', ' ', $semantic_query);
        }

        foreach ($this->_genre_aliases as $alias => $genre)
        {
            if (in_array($genre, $filters['genres'], true))
            {
                $semantic_query = preg_replace('/\b' . preg_quote($alias, '/') . '\b/u', ' ', $semantic_query);
            }
        }

        foreach ($this->_platform_aliases as $alias => $platform)
        {
            if (in_array($platform, $filters['platforms'], true))
            {
                $semantic_query = preg_replace('/\b' . preg_quote($alias, '/') . '\b/u', ' ', $semantic_query);
            }
        }

        $semantic_query = preg_replace('/\s+/', ' ', $semantic_query);

        return trim($semantic_query);
    }

    private function _contains_word(string $query, string $word): bool
    {
        return preg_match('/\b' . preg_quote($word, '/') . '\b/u', $query) === 1;
    }

    private function _contains_phrase(string $query, string $phrase): bool
    {
        return preg_match('/\b' . preg_quote($phrase, '/') . '\b/u', $query) === 1;
    }
}
