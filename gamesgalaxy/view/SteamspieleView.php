<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";

class SteamspieleView extends View
{
    static function show($games)
    {
        echo <<<STEAMSPIELE
<div id="platform-title" class="platform-title">Steam</div>

<div class="games-dropdown-container">
    <div class="games-dropdown">
    <form action="/dwp_ws2324_rkt/gamesgalaxy/Steamspiele/Show" method="post" class="games-dropdown-form">
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
            <option value="strategy">Strategie</option>
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
STEAMSPIELE;

        if (empty($games['games'])) {
            echo '<p>Keine Spiele gefunden</p>';
        } else {
            foreach ($games['games'] as $game) {

                if (isset($game['game_platform']) && $game['game_platform'] === 'Steam') {
                    echo '<div class="games-grid-item">';

                    if (isset($game['game_name'])) {
                        echo '<h2>' . $game['game_name'] . '</h2>';
                    } else {
                        echo '<p>Ungültiger Spielname</p>';
                    }

                    if (isset($game['category_names'])) {
                        $categories = implode(', ', $game['category_names']);
                        echo '<p>Kategorien: ' . $categories . '</p>';
                    } else {
                        echo '<p>Ungültige Kategorien</p>';
                    }

                    if (isset($game['game_price'])) {
                        echo '<p>Preis: ' . $game['game_price'] . '</p>';
                    } else {
                        echo '<p>Ungültiger Preis</p>';
                    }

                    echo '</div>';
                }

            }
        }

        echo '</div></body></html>';

    }
}