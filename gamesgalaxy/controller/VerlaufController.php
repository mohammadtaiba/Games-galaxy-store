<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/VerlaufView.php";

use gamesgalaxy\View\VerlaufView;
class VerlaufController extends Controller
{
    public function actionShow()
    {
        $verlauf_view = new VerlaufView();
        $verlauf_view->title="Meine Einkäufe";
        $verlauf_view->render_html('show', "");
    }
}



