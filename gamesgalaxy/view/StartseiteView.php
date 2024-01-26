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
                            <img id="slide-1" src="/dwp_ws2324_rkt/gamesgalaxy/images/digimon_world_next_order_cover.jpg" alt="Digimon World Next Order cover">
                            <img id="slide-2" src="/dwp_ws2324_rkt/gamesgalaxy/images/digimonstory_cybersleuth_complete_edition_cover.jpg" alt="Digimonstory Cybersleuth complete edition cover">
                            <img id="slide-3" src="/dwp_ws2324_rkt/gamesgalaxy/images/digimon_survive_cover.jpg" alt="Digimon Survive cover">
                        </div>
                        <div class="slider-nav">
                            <a href="#slide-1"></a>
                            <a href="#slide-2"></a>
                            <a href="#slide-3"></a>
                        </div>
                    </div>
                    <div class="slider-informations">
                        <div class="slider-text">Wir durchsuchen hunderte Bibliotheken um die besten Angebote für sie zur verfügung zu stellen. Dabei sind wir auf diese ganz besonderen Angebote gestoßen die sie eventuell interessieren könnten.</div>
                    </div>
                </div>
            </section>
        <div class="grid-kategorie">Bestseller</div>
            <section class="container">
                <div class="slider-description">
                    <div class="slider-wrapper">
                        <div class="slider">
                            <img id="slide-4" src="/dwp_ws2324_rkt/gamesgalaxy/images/remnant_2_cover.jpg" alt="Remnant 2 cover">
                            <img id="slide-5" src="/dwp_ws2324_rkt/gamesgalaxy/images/guilty_gear_strive_cover.jpg" alt="Guilty Gear Strive cover">
                            <img id="slide-6" src="/dwp_ws2324_rkt/gamesgalaxy/images/guild_wars_2_cover.jpg" alt="Guild Wars 2 cover">
                        </div>
                        <div class="slider-nav">
                            <a href="#slide-4"></a>
                            <a href="#slide-5"></a>
                            <a href="#slide-6"></a>
                        </div>
                    </div>
                    <div class="slider-informations">
                        <div class="slider-text">Wir durchsuchen hunderte Bibliotheken um die größten bestseller für sie zur verfügung zu stellen. Dabei sind wir auf diese top Bestseller gestoßen die sie eventuell interessieren könnten.</div>
                    </div>
                </div>
            </section>
        <div class="grid-kategorie">Trends</div>
            <section class="container">
                <div class="slider-description">
                    <div class="slider-wrapper">
                        <div class="slider">
                            <img id="slide-7" src="/dwp_ws2324_rkt/gamesgalaxy/images/cyberpunk_cover.jpg" alt="Cyberpunk cover">
                            <img id="slide-8" src="/dwp_ws2324_rkt/gamesgalaxy/images/dave_the_diver_cover.jpg" alt="Dave the Diver cover">
                            <img id="slide-9" src="/dwp_ws2324_rkt/gamesgalaxy/images/elden_ring_cover.jpg" alt="Elden Ring cover">
                        </div>
                        <div class="slider-nav">
                            <a href="#slide-7"></a>
                            <a href="#slide-8"></a>
                            <a href="#slide-9"></a>
                        </div>
                    </div>
                    <div class="slider-informations">
                        <div class="slider-text">Wir durchsuchen hunderte Bibliotheken um die beliebtesten Trends für sie zur verfügung zu stellen. Dabei fanden wir diese besonderst beliebten Spiele die sie eventuell interessieren könnten.</div>
                    </div>
                </div>
            </section>
STARTSEITE;
    }
}