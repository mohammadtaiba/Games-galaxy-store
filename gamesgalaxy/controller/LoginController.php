<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../model/LoginModel.php";
require_once __DIR__."/../model/EinkaufswagenModel.php";

use gamesgalaxy\Model\LoginModel;
use gamesgalaxy\Model\EinkaufswagenModel;

class LoginController extends Controller
{

    private \mysqli $db;
    public function actionLogin()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login-submit'])) {
            $usermail = $_POST['login-mail'];
            $password = $_POST['login-password'];

            $login_model = new LoginModel();
            if ($login_model->checkCredentials($usermail, $password)) {
                $einkaufswagen_model = new EinkaufswagenModel();
                $einkaufswagen_model->transferTempCartToDatabase($_SESSION['user_id']);

                header("Location: /dwp_ws2324_rkt/gamesgalaxy/Startseite/Show");
            } else {
                echo "Falscher Benutzername oder falsches Passwort.";
            }
        }
    }

    public function actionLogout()
    {
        $_SESSION = array();

        session_destroy();

        header("Location: /dwp_ws2324_rkt/gamesgalaxy/Startseite/Show");
        exit();
    }
}