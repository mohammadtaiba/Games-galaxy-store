<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class ImpressumView extends View
{
    static function show()
    {
        echo <<<IMPRESSUM
     
            <div class="statisch">
            <h1>Impressum</h1>
                <div class="statischinhalt">
                    <div class="kontaktelemente">
                        <h3>Games Galaxy</h3>
                        <p>0815 187187420</p>
                        <p>Musterstraße 1312</p>
                        <p>99084 Erfurt</p>
                        <p>games.galaxy@email.com</p>
                        <h2>Geschäftsführung</h2>
                        <p>Dennis Rinck (CEO)</p>
                        <p>Mohammad Taiba (CEO)</p>
                        <p>Falko Kühn (CEO)</p>
                        <div id="dokumentation">
                            <a href="/dwp_ws2324_rkt/gamesgalaxy/Dokumentation/Show"><h3>Dokumentation ></h3></a>
                        </div>
                    </div>
                </div>
            </div>
IMPRESSUM;
    }
}

