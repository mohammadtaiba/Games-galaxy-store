<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/SpielView.php";
require_once __DIR__."/../model/SpielModel.php";
require_once __DIR__."/../model/EinkaufswagenModel.php";

use gamesgalaxy\View\SpielView;
use gamesgalaxy\Model\SpielModel;
use gamesgalaxy\Model\EinkaufswagenModel;
class SpielController extends Controller
{
    public function actionShow()
    {
        $gameId = $_POST['gameId'] ?? null;

        if ($gameId) {
            $spiel_model = new SpielModel();
            $spiel_data = $spiel_model->getGameById($gameId);

            if ($spiel_data) {
                $spiel_view = new SpielView();
                $spiel_view->title = $spiel_data['game_name'];
                $spiel_view->render_html('show', $spiel_data);
            } else {
                echo 'Spiel nicht gefunden';
            }
        } else {
            echo 'Ungültige Anfrage';
        }
    }

    public function actionAdd()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['gameId'])) {
            $gameId = (int)$_POST['gameId'];

            $einkaufswagen_model = new EinkaufswagenModel();

            if ($einkaufswagen_model->addToCart($gameId)) {
                header("Location: /dwp_ws2324_rkt/gamesgalaxy/Startseite/Show");
            } else {
                echo "Fehler beim Hinzufügen zum Warenkorb.";
            }
        }
    }
}