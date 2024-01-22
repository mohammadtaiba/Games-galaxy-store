<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";

class SearchView extends View
{
    public static function show(array $games)
    {
        echo <<<SEARCH
        <div id="platform-title" class="platform-title">Suchergebnisse</div>
        <div id="searchresults-container">
SEARCH;

        if (empty($games)) {
            echo '<p id="searchresults-nocontent">Keine Spiele gefunden.</p>';
        } else {
            foreach ($games as $game) {
                echo <<<SEARCH
                <div class="searchresults-item" data-game-id="{$game['game_id']}">
                    <h2 class="searchresults-gametitle">{$game['game_name']}</h2>
                    <p class="searchresults-item-content">Plattform: {$game['game_platform']}</p>
                    <p class="searchresults-item-content">{$game['game_price']}€</p>
                    <p class="searchresults-item-content">{$game['game_description']}</p>
                </div>
SEARCH;
            }
        }

        echo <<<SEARCH
        </div>
<script src="/dwp_ws2324_rkt/gamesgalaxy/js/spiel.js"></script>
</body>
</html>
SEARCH;
    }
}
