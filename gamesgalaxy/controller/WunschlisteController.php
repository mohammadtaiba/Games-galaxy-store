<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/WunschlisteView.php";
require_once __DIR__."/../model/WunschlisteModel.php";
require_once __DIR__."/../model/SpielModel.php";

use gamesgalaxy\View\WunschlisteView;
use gamesgalaxy\Model\WunschlisteModel;
use gamesgalaxy\Model\SpielModel;

class WunschlisteController extends Controller
{
    public function actionAdd()
    {
	    if (!$this->isUserAuthenticated()) {
		    echo "<script>alert('Sie sind nicht einloggt.'); window.location.href='/dwp_ws2324_rkt/gamesgalaxy/Startseite/show';</script>";
		    exit();
	    }
        $gameId = $_POST['gameId'] ?? null;

        if ($gameId) {
            $wunschliste_model = new WunschlisteModel();
            $success = $wunschliste_model->addToWishlist($_SESSION['user_id'], $gameId);

            if ($success) {
                header("Location: /dwp_ws2324_rkt/gamesgalaxy/Wunschliste/Show");
            } else {
                echo 'Fehler beim Hinzufügen zur Wunschliste';
            }
        } else {
            echo 'Ungültige Anfrage';
        }
    }
    public function actionShow()
    {
	    if (!$this->isUserAuthenticated()) {
		    echo "<script>alert('Sie sind nicht einloggt.'); window.location.href='/dwp_ws2324_rkt/gamesgalaxy/Startseite/show';</script>";
		    exit();
	    }
        if (isset($_SESSION['user_authenticated'])) {
            $authenticatedUserId = $_SESSION['user_id'];

            $wunschliste_model = new WunschlisteModel();
            $wunschliste_data = $wunschliste_model->getWishlistByUserId($authenticatedUserId);

            $spiel_model = new SpielModel();
            $spiele_data = $spiel_model->getGamesByIds(array_column($wunschliste_data, 'game_id'));

            $wunschliste_view = new WunschlisteView();
            $wunschliste_view->title = "Wunschliste";
            $wunschliste_view->render_html('show', $spiele_data);
        }
    }

    public function actionRemove()
    {
	    if (!$this->isUserAuthenticated()) {
		    echo "<script>alert('Sie sind nicht einloggt.'); window.location.href='/dwp_ws2324_rkt/gamesgalaxy/Startseite/show';</script>";
		    exit();
	    }
        $gameId = $_POST['gameId'];

        $wunschliste_model = new WunschlisteModel();
        $wunschliste_model->removeFromWishlist($_SESSION['user_id'], $gameId);

        header("Location: /dwp_ws2324_rkt/gamesgalaxy/Wunschliste/Show");
        exit();
    }

}