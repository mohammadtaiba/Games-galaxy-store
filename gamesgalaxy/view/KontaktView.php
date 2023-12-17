<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class KontaktView extends View
{
    static function show()
    {
        echo <<<KONTAKT
        <body>
<div class="statisch">
<h1>Kontakt</h1>
    <div class="statischinhalt">
        <div class="kontaktelemente">
            <h3>Dennis Rinck</h3>
            <p>dennis.rinck@fh-erfurt.de</p>
            <h3>Mohammad Taiba</h3>
            <p>mohammad.taiba@fh-erfurt.de</p>
            <h3>Falko Kühn</h3>
            <p>falko.kuehn@fh-erfurt.de</p>
            <h3>Games Galaxy</h3>
            <p>0815 187187420</p>
            <p>Musterstraße 1312</p>
            <p>99084 Erfurt</p>
            <p>games.galaxy@email.com</p>
        </div>
    </div>
</div>
</body>
KONTAKT;
    }
}

