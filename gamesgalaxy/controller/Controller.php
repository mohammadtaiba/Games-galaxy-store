<?php

namespace gamesgalaxy\Controller;

abstract class Controller
{
    protected function isUserAuthenticated()
    {
        return isset($_SESSION['user_authenticated']) && $_SESSION['user_authenticated'] === true;
    }
}
