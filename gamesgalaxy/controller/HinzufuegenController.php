<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/HinzufuegenView.php";
require_once __DIR__."/../model/HinzufuegenModel.php";

use gamesgalaxy\Model\HinzufuegenModel;
use gamesgalaxy\View\HinzufuegenView;
class HinzufuegenController extends Controller
{
    public function actionShow()
    {
        $hinzufuegen_view = new HinzufuegenView();
        $hinzufuegen_view->title="Spiele hinzufügen";
        $hinzufuegen_view->render_html('show', "");
    }

    public function actionSubmit()
    {
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



