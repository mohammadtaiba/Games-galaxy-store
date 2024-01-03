<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../model/LoginModel.php";

use gamesgalaxy\Model\LoginModel;

session_start();

class LoginController extends Controller
{

    private \mysqli $db;
    public function actionLogin()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login-submit'])) {
            $usermail = $_POST['login-mail'];
            $password = $_POST['login-password'];

            $loginModel = new LoginModel();
            if ($loginModel->checkCredentials($usermail, $password)) {
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