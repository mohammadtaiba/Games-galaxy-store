<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/UeberunsView.php";

use gamesgalaxy\View\UeberunsView;

class UeberunsController extends Controller
{
    public function actionShow()
    {
        $ueberuns_view = new UeberunsView();
        $ueberuns_view->title="Über Uns";
        $ueberuns_view->render_html('show', "");
    }
}