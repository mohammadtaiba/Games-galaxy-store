<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/BenutzerlisteView.php";
require_once __DIR__."/../model/BenutzerlisteModel.php";

use gamesgalaxy\Model\BenutzerlisteModel;
use gamesgalaxy\View\BenutzerlisteView;

class BenutzerlisteController extends Controller
{
    public function actionShow()
    {
	    if (!$this->isUserAuthenticated()) {
		    header("Location: /dwp_ws2324_rkt/gamesgalaxy/Login");
		    exit();
	    }
        if (isset($_SESSION['user_authenticated']) && $_SESSION['user_authenticated']) {
            $currentUserId = $_SESSION['user_id'];

            $benutzerliste_model = new BenutzerlisteModel();
            $users = $benutzerliste_model->get_all_users_except_current($currentUserId);

            $benutzerliste_view = new BenutzerlisteView();
            $benutzerliste_view->title = "Benutzerliste";
            $benutzerliste_view->render_html('show', $users);
        } else {
            echo "Benutzer hat kein zugriff auf die Benutzerliste";
        }
    }

    public function actionDeleteUser()
    {
	    if (!$this->isUserAuthenticated()) {
		    header("Location: /dwp_ws2324_rkt/gamesgalaxy/Login");
		    exit();
	    }
        $userId = $_POST['user_id'];

        $benutzerliste_model = new BenutzerlisteModel();
        $benutzerliste_model->delete_user($userId);

        header("Location: /dwp_ws2324_rkt/gamesgalaxy/Benutzerliste/Show");
        exit();
    }

}
