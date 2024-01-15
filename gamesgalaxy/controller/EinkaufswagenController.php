<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/EinkaufswagenView.php";
require_once __DIR__."/../model/EinkaufswagenModel.php";

use gamesgalaxy\View\EinkaufswagenView;
use gamesgalaxy\Model\EinkaufswagenModel;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class EinkaufswagenController extends Controller
{
    public function actionShow()
    {
        $einkaufswagen_view = new EinkaufswagenView();
        $einkaufswagen_view->title="Einkaufswagen";
        $einkaufswagen_view->render_html('show', "");
    }

    public function actionRemove()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_game_id'])) {
            $gameId = (int)$_POST['remove_game_id'];

            $einkaufswagen_model = new EinkaufswagenModel();

            if ($einkaufswagen_model->removeFromCart($gameId)) {
                header("Location: /dwp_ws2324_rkt/gamesgalaxy/Einkaufswagen/Show");
            } else {
                echo "Fehler beim Entfernen des Spiels aus dem Einkaufswagen.";
            }
        }
    }
}
