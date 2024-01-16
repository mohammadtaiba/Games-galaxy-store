<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/DokumentationView.php";

use gamesgalaxy\View\DokumentationView;
class DokumentationController extends Controller
{
    public function actionShow()
    {
        $dokumentation_view = new DokumentationView();
        $dokumentation_view->title="Dokumentation";
        $dokumentation_view->render_html('show', "");
    }
}
