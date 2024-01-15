<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class SpielView extends View
{
    static function show($spiel_data)
    {
        $gameName = $spiel_data['game_name'] ?? 'Unbekanntes Spiel';
        $platform = $spiel_data['game_platform'] ?? 'Unbekannte Plattform';
        $price = $spiel_data['game_price'] ?? 'Unbekannter Preis';
        $description = $spiel_data['game_description'] ?? 'Keine Beschreibung verfügbar';
        $gameId = $spiel_data['game_id'] ?? null;

        echo <<<SPIEL

            <div class="spiel-flex">
                <div><img src="/dwp_ws2324_rkt/gamesgalaxy/images/guilty_gear_strive_cover.jpg" class="spiele-images" alt="Cover für das zweite Spiel"></div>
                <div class="kauf-infos">
                        <div id="spiel-name-flex">
                            <div id="spiel-name">$gameName</div>
                        </div>
                        <div id="spiel-plattform">$platform</div>
                        <div id="spiel-preis">$price €</div>
                        <div id="kauf-options-flex">
                        <form method="post" action="/dwp_ws2324_rkt/gamesgalaxy/Spiel/Add">
                        <input type="hidden" name="gameId" value="$gameId">
                        <button type="submit" id="warenkorb-hinzufuegen"><i class="fa-solid fa-cart-shopping"></i></button>
                        </form>
                        <button id="sofort-kauf">Sofort kaufen</button> 
                        <form method="post" action="/dwp_ws2324_rkt/gamesgalaxy/Wunschliste/Add">
                        <input type="hidden" name="gameId" value="$gameId">
                        <button type="submit" class="add-game-wishlist"> <i class="fa-solid fa-plus"></i></button> 
                        </form>
                        </div>
                </div>
            </div>
            <div>
                <div class="spiel-beschreibung">Beschreibung</div>
                <div id="spiel-beschreibung-text-flex">
                <div class="spiel-beschreibung-text">$description</div>
                </div>
            </div>
SPIEL;
    }
}