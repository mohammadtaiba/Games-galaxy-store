<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/WunschlisteView.php";

use gamesgalaxy\View\WunschlisteView;

class WunschlisteController extends Controller
{
    public function actionShow()
    {
        $wunschliste_view = new WunschlisteView();
        $wunschliste_view->title = "Wunschliste";
        $wunschliste_view->render_html('show', "");
    }
}