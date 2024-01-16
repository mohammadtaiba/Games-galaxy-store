<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class DokumentationView extends View
{
    static function show()
    {
        echo <<<DOKUMENTATION
        Dokumentation
</body>
DOKUMENTATION;
    }
}

