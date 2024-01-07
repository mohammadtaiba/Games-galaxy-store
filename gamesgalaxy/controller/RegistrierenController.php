<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/RegistrierenView.php";
require_once __DIR__."/../model/RegistrierenModel.php";

use gamesgalaxy\Model\RegistrierenModel;
use gamesgalaxy\View\RegistrierenView;
class RegistrierenController extends Controller
{
    public function actionShow()
    {
        $registrieren_view = new RegistrierenView();
        $registrieren_view->title="Registrieren";
        $registrieren_view->render_html('show', "");
    }

    public function actionSubmit()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $registrieren_model = new RegistrierenModel();
            $registrieren_model->submit_userdata();
        }
    }
}



