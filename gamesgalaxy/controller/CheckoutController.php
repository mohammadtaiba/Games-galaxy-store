<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/CheckoutView.php";

use gamesgalaxy\View\CheckoutView;
class CheckoutController extends Controller
{
    public function actionShow()
    {
        $checkout_view = new CheckoutView();
        $checkout_view->title="Checkout";
        $checkout_view->render_html('show', "");
    }
}