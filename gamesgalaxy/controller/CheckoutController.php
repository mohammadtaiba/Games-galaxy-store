<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/CheckoutView.php";
require_once __DIR__."/../model/CheckoutModel.php";

use gamesgalaxy\View\CheckoutView;
use gamesgalaxy\Model\CheckoutModel;
class CheckoutController extends Controller
{
    public function actionShow()
    {
	    if (!$this->isUserAuthenticated()) {
		    header("Location: /dwp_ws2324_rkt/gamesgalaxy/Login");
		    exit();
	    }
        $userId = $_SESSION['user_id'];

        $checkout_model = new CheckoutModel();
        $userData = $checkout_model->getUserData($userId);
        $cartItems = $checkout_model->getCartItems($userId);

        $checkout_view = new CheckoutView();
        $checkout_view->title="Checkout";
        $checkout_view->render_html('show', ['cartItems' => $cartItems, 'userData' => $userData]);
    }
}