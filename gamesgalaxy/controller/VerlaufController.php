<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/VerlaufView.php";

use gamesgalaxy\View\VerlaufView;
class VerlaufController extends Controller
{
    public function actionShow()
    {
	    if (!$this->isUserAuthenticated()) {
		    header("Location: /dwp_ws2324_rkt/gamesgalaxy/Login");
		    exit();
	    }
        $verlauf_view = new VerlaufView();
        $verlauf_view->title="Meine Einkäufe";
        $verlauf_view->render_html('show', "");
    }
}



