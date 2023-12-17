<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/FaqView.php";

use gamesgalaxy\View\FaqView;
class FaqController extends Controller
{
    public function actionShow()
    {
        $faq_view = new FaqView();
        $faq_view->title="FAQ";
        $faq_view->render_html('show', "");
    }
}



