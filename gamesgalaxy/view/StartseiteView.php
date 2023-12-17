<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class StartseiteView extends View
{

    static function show()
    {
        echo <<<STARTSEITE
        <body>
            <div class="StartseiteGrids">
                <div class="grid-kategorie">Angebote</div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-left fa-xl"></i></button></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/cyberpunk_cover.jpg" class="game-images" alt="Cover für das erste Spiel"></a><div class="grid-element-background">Cyberpunk 2077</div></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/dave_the_diver_cover.jpg" class="game-images"  alt="Cover für das zweite Spiel"></a><div class="grid-element-background">Dave the Diver</div></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/elden_ring_cover.jpg" class="game-images" alt="Cover für das dritte Spiel"></a><div class="grid-element-background">Elden Ring</div></div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-right fa-xl"></i></button></div>
            </div>
            <div class="StartseiteGrids">
                <div class="grid-kategorie">Bestseller</div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-left fa-xl"></i></button></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/remnant_2_cover.jpg" class="game-images" alt="Cover für das erste Spiel"></a><div class="grid-element-background">Remnant 2</div></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/guilty_gear_strive_cover.jpg" class="game-images" alt="Cover für das zweite Spiel"></a><div class="grid-element-background">Guilty Gear Strive</div></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/guild_wars_2_cover.jpg" class="game-images" alt="Cover für das dritte Spiel"></a><div class="grid-element-background">Guild Wars 2</div></div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-right fa-xl"></i></button></div>
            </div>
            <div class="StartseiteGrids">
                <div class="grid-kategorie">Trends</div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-left fa-xl"></i></button></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/digimon_world_next_order_cover.jpg" class="game-images" alt="Cover für das erste Spiel"></a><div class="grid-element-background">Digimon World Next Order</div></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/digimonstory_cybersleuth_complete_edition_cover.jpg" class="game-images" alt="Cover für das zweite Spiel"></a><div class="grid-element-background">Digimonstory Cybersleuth Complete Edition</div></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/digimon_survive_cover.jpg" class="game-images" alt="Cover für das dritte Spiel"></a><div class="grid-element-background">Digimon Survive</div></div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-right fa-xl"></i></button></div>
            </div>
        </body>
STARTSEITE;
    }
}