<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/HinzufuegenView.php";
require_once __DIR__."/../model/HinzufuegenModel.php";

use gamesgalaxy\Model\HinzufuegenModel;
use gamesgalaxy\View\HinzufuegenView;
class HinzufuegenController extends Controller
{
	private $hinzufuegenModel;

	public function __construct() {
		$this->hinzufuegenModel = new HinzufuegenModel();
	}


	public function actionShow() {

		if (!$this->isUserAuthenticated()) {
			header("Location: /dwp_ws2324_rkt/gamesgalaxy/Login");
			exit();
		}

		$userId = $_SESSION['user_id'] ?? null;
		$hasCreateGamePermission = $userId ? $this->hinzufuegenModel->userHasPermission($userId, 'create_game') : false;

		if ($hasCreateGamePermission) {
			$hinzufuegen_view = new HinzufuegenView();
			$hinzufuegen_view->title = "Spiele hinzufügen";
			$hinzufuegen_view->render_html('show', "");
		} else {
			echo "<script>alert('Sie haben keine Berechtigung, ein Spiel hinzuzufügen.'); window.location.href='/dwp_ws2324_rkt/gamesgalaxy/Startseite/show';</script>";
			exit;
		}
	}


    public function actionSubmit()
    {
	    if (!$this->isUserAuthenticated()) {
		    header("Location: /dwp_ws2324_rkt/gamesgalaxy/Login");
		    exit();
	    }

	    $userId = $_SESSION['user_id'];

	    if (!$this->hinzufuegenModel->userHasPermission($userId, 'create_game')) {
		    echo "Sie sind nicht berichtigt ein Spiel hinzuzufügen!";
		    exit();
	    }

        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $hinzufuegen_model = new HinzufuegenModel();

            $gameTitle = $_POST['addgame-title'];
            $gameCategory = isset($_POST['addgame-category']) ? $_POST['addgame-category'] : [];
            $gamePlatform = $_POST['addgame-platform'];
            $gameKey = $_POST['addgame-key'];
            $gamePrice = $_POST['addgame-price'];
            $gameDescription = $_POST['addgame-description'];

            $hinzufuegen_model->createGame($gamePlatform, $gameTitle, $gamePrice, $gameDescription, $gameKey, $gameCategory);

            header("Location: /dwp_ws2324_rkt/gamesgalaxy/Hinzufuegen/Show");
            exit();
        }
    }

}



