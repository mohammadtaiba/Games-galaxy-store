<?php

require_once 'controller/Controller.php';
require_once 'controller/ImpressumController.php';


preg_match('/\/dwp_ws2324_rkt\/gamesgalaxy\/(?<controller>[^\/]*)\/(?<action>[^\/]*)/',$_SERVER['REQUEST_URI'],$matches);

$controllerClassName = "\\gamesgalaxy\\controller\\{$matches['controller']}Controller";

$controllerInstance = new $controllerClassName();

$actionMethodName = 'action' . $matches['action'];

$controllerInstance->$actionMethodName();
