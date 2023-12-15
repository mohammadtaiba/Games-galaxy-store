<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/KontaktView.php";

use gamesgalaxy\View\KontaktView;
class KontaktController extends Controller
{
    public function actionShow()
    {
        $kontakt_view = new KontaktView();
        $kontakt_view->title="Kontakt";
        $kontakt_view->render_html('show', "");
    }
}
