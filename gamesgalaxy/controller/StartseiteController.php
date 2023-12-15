<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/StartseiteView.php";

use gamesgalaxy\View\StartseiteView;
class StartseiteController extends Controller
{
    public function actionShow()
    {
        $startseite_view = new StartseiteView();
        $startseite_view->title="Games Galaxy";
        $startseite_view->render_html('show', "");
    }

}