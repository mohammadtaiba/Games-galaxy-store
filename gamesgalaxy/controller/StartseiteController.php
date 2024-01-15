<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/StartseiteView.php";
require_once __DIR__."/../model/EinkaufswagenModel.php";

use gamesgalaxy\View\StartseiteView;
use gamesgalaxy\Model\EinkaufswagenModel;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class StartseiteController extends Controller
{
    public function actionShow()
    {
        $einkaufswagen_model = new EinkaufswagenModel();
        $cartItems = $einkaufswagen_model->getCart();

        $startseite_view = new StartseiteView();
        $startseite_view->title="Games Galaxy";
        $startseite_view->render_html('show', "");
    }

}