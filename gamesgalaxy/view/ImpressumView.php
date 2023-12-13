<?php

namespace gamesgalaxy\View;

require_once 'View.php';
require_once 'lib/Styles.php';
class ImpressumView extends View
{
    static function show()
    {
        echo <<<IMPRESSUM
        <body>
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
                            <a href="https://onedrive.live.com/?authkey=%21ANM5jF6w%5FLJs2Vg&id=8B04937D20B87665%2149190&cid=8B04937D20B87665"><h3>Dokumentation ></h3></a>
                            <a href="database.php">Datenbankverbindung öffnen</a><br>
                            <a href="close_connection.php">Datenbankverbindung schließen</a>
                        </div>
                    </div>
                </div>
            </div>
        </body>
IMPRESSUM;
    }
}

