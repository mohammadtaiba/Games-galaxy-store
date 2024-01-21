<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class StartseiteView extends View
{

    static function show()
    {
        echo <<<STARTSEITE
        <div class="grid-kategorie">Angebote</div>
            <section class="container">
                <div class="slider-description">
                    <div class="slider-wrapper">
                        <div class="slider">
                            <img id="slide-1" src="/dwp_ws2324_rkt/gamesgalaxy/images/digimon_world_next_order_cover.jpg" alt="">
                            <img id="slide-2" src="/dwp_ws2324_rkt/gamesgalaxy/images/digimonstory_cybersleuth_complete_edition_cover.jpg" alt="">
                            <img id="slide-3" src="/dwp_ws2324_rkt/gamesgalaxy/images/digimon_survive_cover.jpg" alt="">
                        </div>
                        <div class="slider-nav">
                            <a href="#slide-1"></a>
                            <a href="#slide-2"></a>
                            <a href="#slide-3"></a>
                        </div>
                    </div>
                    <div id="slider-informations">
                        <div class="slider-game-name">Digimon World Next Order</div>
                        <div class="slider-game-description">The Digital World has run rampant with Machinedramon and is now in a state of utter chaos. As a Digidestined, it’s up to you to restore order to the world in Digimon World: Next Order, a monster collecting RPG</div>
                        <div class="slider-price">24.99€</div>
                    </div>
                </div>
            </section>
            <div class="StartseiteGrids">
                <div class="grid-kategorie">Bestseller</div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-left fa-xl"></i></button></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="/dwp_ws2324_rkt/gamesgalaxy/images/remnant_2_cover.jpg" class="game-images" alt="Cover für das erste Spiel"></a><div class="grid-element-background">Remnant 2</div></div>
                <div class="grid-element"><a class="game-images" href="/dwp_ws2324_rkt/gamesgalaxy/Spiel/Show"><img src="/dwp_ws2324_rkt/gamesgalaxy/images/guilty_gear_strive_cover.jpg" class="game-images" alt="Cover für das zweite Spiel"></a><div class="grid-element-background">Guilty Gear Strive</div></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="/dwp_ws2324_rkt/gamesgalaxy/images/guild_wars_2_cover.jpg" class="game-images" alt="Cover für das dritte Spiel"></a><div class="grid-element-background">Guild Wars 2</div></div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-right fa-xl"></i></button></div>
            </div>
            <div class="StartseiteGrids">
                <div class="grid-kategorie">Trends</div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-left fa-xl"></i></button></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="/dwp_ws2324_rkt/gamesgalaxy/images/cyberpunk_cover.jpg" class="game-images" alt="Cover für das erste Spiel"></a><div class="grid-element-background">Cyberpunk</div></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="/dwp_ws2324_rkt/gamesgalaxy/images/dave_the_diver_cover.jpg" class="game-images" alt="Cover für das zweite Spiel"></a><div class="grid-element-background">Dave the Diver</div></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="/dwp_ws2324_rkt/gamesgalaxy/images/elden_ring_cover.jpg" class="game-images" alt="Cover für das dritte Spiel"></a><div class="grid-element-background">Elden Ring</div></div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-right fa-xl"></i></button></div>
            </div>
        </body>
STARTSEITE;
    }
}