<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/SpielView.php";

use gamesgalaxy\View\SpielView;
class SpielController extends Controller
{
    public function actionShow()
    {
        $spiel_view = new SpielView();
        $spiel_view->title="Spiele Name";
        $spiel_view->render_html('show', "");
    }

}