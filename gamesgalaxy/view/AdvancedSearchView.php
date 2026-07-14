<?php

namespace gamesgalaxy\View;

require_once __DIR__ . "/../view/View.php";

class AdvancedSearchView extends View
{
    public static function show(array $result)
    {
        $games = $result['games'] ?? [];
        $meta = $result['meta'] ?? [];
        $query = self::_escape($meta['raw_query'] ?? '');
        $filter_summary = self::_format_filters($meta['filters'] ?? []);

        echo <<<ADVANCEDSEARCH
<div id="platform-title" class="platform-title">Erweiterte KI-Suche</div>

<div id="advanced-search-container">
    <form action="/dwp_ws2324_rkt/gamesgalaxy/AdvancedSearch/Show" method="get" id="advanced-search-form">
        <label for="advancedSearchInput">Beschreibe dein Wunschspiel</label>
        <div id="advanced-search-input-row">
            <input type="text" name="q" id="advancedSearchInput" value="$query" placeholder="Steam-Spiele unter 25 Euro mit Koop und Story">
            <button type="submit">KI-Suche</button>
        </div>
    </form>
ADVANCEDSEARCH;

        if (($meta['fallback_used'] ?? false) === true)
        {
            $fallback_reason = self::_escape($meta['fallback_reason'] ?? 'Erweiterte KI-Suche nicht verfügbar.');
            echo '<p class="advanced-search-notice">Die erweiterte KI-Suche ist aktuell nicht verfügbar. Es wurde die Standardsuche verwendet.</p>';
            echo '<p class="advanced-search-meta">Grund: ' . $fallback_reason . '</p>';
        }
        elseif ($query !== '')
        {
            if (($meta['source'] ?? '') === 'elasticsearch_vector')
            {
                echo '<p class="advanced-search-meta">Quelle: KI-Suche mit Elasticsearch und semantischer Ähnlichkeit.</p>';
            }
            else
            {
                echo '<p class="advanced-search-meta">Quelle: KI-Suche mit Elasticsearch-Volltextsuche und exakten Filtern.</p>';
            }
        }

        if ($filter_summary !== '')
        {
            echo '<p class="advanced-search-meta">Exakte Filter: ' . $filter_summary . '</p>';
        }

        echo '<div id="searchresults-container">';

        if ($query !== '' && empty($games))
        {
            echo '<p id="searchresults-nocontent">Keine Spiele gefunden.</p>';
        }
        elseif ($query === '')
        {
            echo '<p id="searchresults-nocontent">Gib eine Suchanfrage ein.</p>';
        }
        else
        {
            foreach ($games as $game)
            {
                self::_render_game($game);
            }
        }

        echo <<<ADVANCEDSEARCH
        </div>
    </div>
<script src="/dwp_ws2324_rkt/gamesgalaxy/js/spiel.js"></script>
ADVANCEDSEARCH;
    }

    private static function _render_game(array $game): void
    {
        $game_id = self::_escape((string) ($game['game_id'] ?? ''));
        $game_name = self::_escape($game['game_name'] ?? 'Unbekanntes Spiel');
        $game_platform = self::_escape($game['game_platform'] ?? 'Unbekannte Plattform');
        $game_price = self::_escape($game['game_price'] ?? '0,00');
        $game_description = self::_escape($game['game_description'] ?? '');
        $categories = self::_escape(self::_format_categories($game['category_names'] ?? []));
        $modes = self::_escape(self::_format_modes($game));

        echo <<<ADVANCEDSEARCH
        <div class="searchresults-item" data-game-id="$game_id">
            <h2 class="searchresults-gametitle">$game_name</h2>
            <p class="searchresults-item-content">Plattform: $game_platform</p>
            <p class="searchresults-item-content">Genres: $categories</p>
            <p class="searchresults-item-content">Modus: $modes</p>
            <p class="searchresults-item-content">$game_price &euro;</p>
            <p class="searchresults-item-content">$game_description</p>
        </div>
ADVANCEDSEARCH;
    }

    private static function _format_filters(array $filters): string
    {
        $parts = [];

        if (!empty($filters['price']))
        {
            $operator_labels = [
                'lte' => 'Preis bis',
                'gte' => 'Preis ab',
                'eq' => 'Preis'
            ];
            $operator = $filters['price']['operator'] ?? 'eq';
            $label = $operator_labels[$operator] ?? 'Preis';
            $parts[] = $label . ' ' . number_format((float) $filters['price']['value'], 2, ',', '.') . ' Euro';
        }

        if (!empty($filters['genres']))
        {
            $parts[] = 'Genre ' . implode(', ', $filters['genres']);
        }

        if (!empty($filters['platforms']))
        {
            $parts[] = 'Plattform ' . implode(', ', $filters['platforms']);
        }

        if (($filters['is_online'] ?? null) === true)
        {
            $parts[] = 'online spielbar';
        }

        if (($filters['is_offline'] ?? null) === true)
        {
            $parts[] = 'offline spielbar';
        }

        return self::_escape(implode(' | ', $parts));
    }

    private static function _format_categories($categories): string
    {
        if (is_array($categories))
        {
            return implode(', ', array_filter($categories));
        }

        if (is_string($categories) && $categories !== '')
        {
            return $categories;
        }

        return 'Keine Kategorie';
    }

    private static function _format_modes(array $game): string
    {
        $modes = [];

        if (!empty($game['game_is_online']))
        {
            $modes[] = 'Online';
        }

        if (!empty($game['game_is_offline']))
        {
            $modes[] = 'Offline';
        }

        if (empty($modes))
        {
            return 'Nicht gepflegt';
        }

        return implode(', ', $modes);
    }

    private static function _escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
