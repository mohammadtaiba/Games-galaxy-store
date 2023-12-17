<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/ImpressumView.php";

use gamesgalaxy\View\ImpressumView;
class ImpressumController extends Controller
{
    public function actionShow()
    {
        $impressum_view = new ImpressumView();
        $impressum_view->title="Impressum";
        $impressum_view->render_html('show', "");
    }
}



