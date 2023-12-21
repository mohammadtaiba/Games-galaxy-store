<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/BearbeitenView.php";
require_once __DIR__."/../model/BearbeitenModel.php";

use gamesgalaxy\View\BearbeitenView;
class BearbeitenController extends Controller
{
    public function actionShow()
    {
        $bearbeiten_view = new BearbeitenView();
        $bearbeiten_view->title="Profil Bearbeiten";
        $bearbeiten_view->render_html('show', "");
    }
}
