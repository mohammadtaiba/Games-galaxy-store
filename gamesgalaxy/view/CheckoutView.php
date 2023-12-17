<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class CheckoutView extends View
{
    static function show()
    {
        echo <<<CHECKOUT

CHECKOUT;
    }
}

