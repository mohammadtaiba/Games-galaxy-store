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
            echo "<script>alert('Sie sind nicht einloggt.'); window.location.href='/dwp_ws2324_rkt/gamesgalaxy/Startseite/show';</script>";
            exit();
        }
        $userId = $_SESSION['user_id'];

        $checkout_model = new CheckoutModel();
        $userData = $checkout_model->getUserData($userId);
        $cartItems = $checkout_model->getCartItems($userId);

        if (empty($cartItems)) {
            echo "<script>alert('Ihr Warenkorb ist leer.'); window.location.href='/dwp_ws2324_rkt/gamesgalaxy/Startseite/show';</script>";
            exit();
        }


        $checkout_view = new CheckoutView();
        $checkout_view->title="Checkout";
        $checkout_view->render_html('show', ['cartItems' => $cartItems, 'userData' => $userData]);
    }

    public function actionProcessCheckout()
    {
        if (!$this->isUserAuthenticated()) {
            echo "<script>alert('Sie sind nicht einloggt.'); window.location.href='/dwp_ws2324_rkt/gamesgalaxy/Startseite/show';</script>";
            exit();
        }
        echo "POST-Daten: ";

        $paymentMethod = isset($_POST['payment-method']) ? $_POST['payment-method'] : null;

        if ($paymentMethod === null) {
            exit();
        }

        $checkout_model = new CheckoutModel();
        $userId = $_SESSION['user_id'];
        $userData = $checkout_model->getUserData($userId);
        $cartItems = $checkout_model->getCartItems($userId);

        $checkout_model->saveOrder($userId, $cartItems, $userData, $paymentMethod);

        $checkout_model->clearCartItems($userId);

        header("Location: /dwp_ws2324_rkt/gamesgalaxy/Verlauf/Show");
        exit();
    }
}