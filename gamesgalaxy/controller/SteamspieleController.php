<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/SteamspieleView.php";

use gamesgalaxy\View\SteamspieleView;
class SteamspieleController extends Controller
{
    public function actionShow()
    {
        $steamspiele_view = new SteamspieleView();
        $steamspiele_view->title="Steam";
        $steamspiele_view->render_html('show', "");
    }
}