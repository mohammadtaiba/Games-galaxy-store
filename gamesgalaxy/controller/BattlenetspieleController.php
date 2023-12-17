<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/BattlenetspieleView.php";

use gamesgalaxy\View\BattlenetspieleView;
class BattlenetspieleController extends Controller
{
    public function actionShow()
    {
        $battlenetspiele_view = new BattlenetspieleView();
        $battlenetspiele_view->title="Battle.net";
        $battlenetspiele_view->render_html('show', "");
    }
}