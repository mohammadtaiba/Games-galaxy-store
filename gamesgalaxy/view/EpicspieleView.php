<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";

class EpicspieleView extends View
{
    static function show($games)
    {
        echo <<<EPICSPIELE
<div id="platform-title" class="platform-title">Epic Games</div>

<div class="games-dropdown-container">
    <div class="games-dropdown">
    <form action="/dwp_ws2324_rkt/gamesgalaxy/Epicspiele/Show" method="post" class="games-dropdown-form">
        <div class="games-form-row">
        <label for="sortby">Sortieren nach:</label>
        <select id="sortby" name="sortby">
            <option value="game-name-descending">Name (absteigend)</option>
            <option value="game-name-ascending">Name (aufsteigend)</option>
            <option value="game-price-descending">Preis (absteigend)</option>
            <option value="game-price-ascending">Preis (aufsteigend)</option>
        </select>
    </div>
    <div class="games-form-row">
        <label for="filterby">Filtern nach:</label>
        <select id="filterby" name="filterby">
            <option value="all">Alle Kategorien</option>
            <option value="strategie">Strategie</option>
            <option value="action">Action</option>
            <option value="shooter">Shooter</option>
            <option value="rpg">RPG</option>
            <option value="simulation">Simulation</option>
        </select>
    </div>
    <div class="games-form-row">
        <button type="submit" class="games-form-button">Anwenden</button>
    </div>
    </form>
    </div>
</div>

<div class="games-grid-container">
EPICSPIELE;

        if (empty($games['games'])) {
            echo '<p>Keine Spiele gefunden</p>';
        } else {
            foreach ($games['games'] as $game) {

                if (isset($game['game_platform']) && $game['game_platform'] === 'Epic Games') {
                    echo '<div class="games-grid-item" data-game-id="' . $game['game_id'] . '">';

                    if (isset($game['game_name'])) {
                        echo '<h2>' . $game['game_name'] . '</h2>';
                    } else {
                        echo '<p>Ungültiger Spielname</p>';
                    }

                    if (isset($game['category_names'])) {
                        $categories = implode(', ', $game['category_names']);
                        echo '<p>' . $categories . '</p>';
                    } else {
                        echo '<p>Ungültige Kategorien</p>';
                    }

                    if (isset($game['game_price'])) {
                        echo '<p>' . $game['game_price'] . '€</p>';
                    } else {
                        echo '<p>Ungültiger Preis</p>';
                    }

                    echo '</div>';
                }

            }
        }

        echo '</div><script src="/dwp_ws2324_rkt/gamesgalaxy/js/spiel.js"></script></body></html>';

    }
}