<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/EpicspieleView.php";

use gamesgalaxy\View\EpicspieleView;
class EpicspieleController extends Controller
{
    public function actionShow()
    {
        $epicspiele_view = new EpicspieleView();
        $epicspiele_view->title="Epic Games";
        $epicspiele_view->render_html('show', "");
    }
}