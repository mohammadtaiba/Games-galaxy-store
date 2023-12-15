<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/RegistrierenView.php";

use gamesgalaxy\View\RegistrierenView;
class RegistrierenController extends Controller
{
    public function actionShow()
    {
        $registrieren_view = new RegistrierenView();
        $registrieren_view->title="Registrieren";
        $registrieren_view->render_html('show', "");
    }
}



