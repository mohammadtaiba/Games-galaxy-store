<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/HinzufuegenView.php";

use gamesgalaxy\View\HinzufuegenView;
class HinzufuegenController extends Controller
{
    public function actionShow()
    {
        $hinzufuegen_view = new HinzufuegenView();
        $hinzufuegen_view->title="Spiele hinzufügen";
        $hinzufuegen_view->render_html('show', "");
    }
}



