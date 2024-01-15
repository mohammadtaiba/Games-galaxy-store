<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";

class WunschlisteView extends View
{
    static function show($wunschliste_data)
    {
        echo <<<WUNSCHLISTE
            <div id="titel-einkaufe">
                <p>Meine Wunschliste</p>
            </div>
            <div id="einkaufe-grid">
                <div class="flex-grid">
WUNSCHLISTE;

        foreach ($wunschliste_data as $spiel) {
            $gameName = $spiel['game_name'] ?? 'Unbekanntes Spiel';
            $price = $spiel['game_price'] ?? 'Unbekannter Preis';
            $platform = $spiel['game_platform'] ?? 'Unbekannte Plattform';
            $spielId = $spiel['game_id'] ?? 'Unbekannte ID';

            echo <<<SPIEL
                    <div class="wunschliste-grid-inhalt" data-game-id="$spielId">
                        <div class="wunschliste-daten">
                            <div class="wunschliste-daten-inhalt">
                                <p class="wunschliste-uberschrift">$gameName</p>
                                <p>$price €</p>
                                <p>$platform</p>
                            </div>
                        </div>
                        <div class="spiele-entfernen">
                            <form method="post" action="/dwp_ws2324_rkt/gamesgalaxy/Wunschliste/Remove">
                                <input type="hidden" name="gameId" value="$spielId">
                                <button type="submit" class="remove-element"><i class="fa-solid fa-trash fa-xl"></i></button>
                            </form>
                        </div>
                    </div>
SPIEL;
        }

        echo <<<WUNSCHLISTE
                </div>
            </div>          
        <script src="/dwp_ws2324_rkt/gamesgalaxy/js/spiel.js"></script></body>
WUNSCHLISTE;
    }
}

