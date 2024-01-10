<?php

require_once 'controller/Controller.php';
require_once 'controller/ImpressumController.php';
require_once 'controller/StartseiteController.php';
require_once 'controller/WunschlisteController.php';
require_once 'controller/UeberunsController.php';
require_once 'controller/SteamspieleController.php';
require_once 'controller/HinzufuegenController.php';
require_once 'controller/RegistrierenController.php';
require_once 'controller/BearbeitenController.php';
require_once 'controller/KontaktController.php';
require_once 'controller/EpicspieleController.php';
require_once 'controller/BattlenetspieleController.php';
require_once 'controller/FaqController.php';
require_once 'controller/VerlaufController.php';
require_once 'controller/CheckoutController.php';
require_once 'controller/LoginController.php';
require_once 'controller/BenutzerlisteController.php';
require_once 'controller/SpielController.php';


preg_match('/\/dwp_ws2324_rkt\/gamesgalaxy\/(?<controller>[^\/]*)\/(?<action>[^\/]*)/', $_SERVER['REQUEST_URI'], $matches);

if (key_exists("controller", $matches)) {
    $controllerClassName = "\\gamesgalaxy\\controller\\" . ucfirst($matches['controller']) . "Controller";
} else {
    $controllerClassName = "\\gamesgalaxy\\controller\\StartseiteController";
}


if (class_exists($controllerClassName)) {
    $controllerInstance = new $controllerClassName();

    if (key_exists("action", $matches)) {
        $actionMethodName = 'action' . ucfirst($matches['action']);
    }
    else {
        $actionMethodName = 'actionShow';
    }

    if (method_exists($controllerInstance, $actionMethodName)) {
        $controllerInstance->$actionMethodName();
    } else {
        print "Error 404";
    }

} else {
    print "Error 404";
}



