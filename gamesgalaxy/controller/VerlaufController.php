<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/VerlaufView.php";
require_once __DIR__."/../model/VerlaufModel.php";

use gamesgalaxy\View\VerlaufView;
use gamesgalaxy\Model\VerlaufModel;
class VerlaufController extends Controller
{
    public function actionShow()
    {
        $verlauf_model = new VerlaufModel();
        $userId = $_SESSION['user_id'];
        $orderHistory = $verlauf_model->getOrderHistory($userId);

        $verlauf_view = new VerlaufView();
        $verlauf_view->title = "Meine Einkäufe";
        $verlauf_view->render_html('show', $orderHistory);
    }
}



