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
require_once 'controller/EinkaufswagenController.php';
require_once 'controller/DokumentationController.php';
require_once 'controller/SearchController.php';

preg_match('/^\/dwp_ws2324_rkt\/gamesgalaxy\/(?<controller>[^\/]+)\/?(?<action>[^\/?]+)?/', $_SERVER['REQUEST_URI'], $matches);


$controllerName = ucfirst(strtolower($matches['controller'] ?? 'startseite')) . 'Controller';
$actionName = 'action' . ucfirst(strtolower($matches['action'] ?? 'show'));

$controllerClassName = "\\gamesgalaxy\\Controller\\$controllerName";
$actionMethodName = $actionName;


if (class_exists($controllerClassName)) {
	$controllerInstance = new $controllerClassName();

	error_log("Gefundener Controller: $controllerClassName");
	error_log("Zu aufrufende Aktion: $actionMethodName");

	if (method_exists($controllerInstance, $actionMethodName)) {
		$controllerInstance->$actionMethodName();
	} else {
		error_log("Die Methode $actionMethodName existiert nicht in $controllerClassName");
		header("HTTP/1.0 404 Not Found");
		echo "Error 404: Action not found";
	}
} else {
	error_log("Controller $controllerClassName nicht gefunden");
	header("HTTP/1.0 404 Not Found");
	echo "Error 404: Controller not found";
}


