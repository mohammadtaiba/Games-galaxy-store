<?php

namespace gamesgalaxy\Controller;

require_once __DIR__."/../view/BearbeitenView.php";
require_once __DIR__."/../model/BearbeitenModel.php";
require_once __DIR__."/../model/LoginModel.php";

use gamesgalaxy\View\BearbeitenView;
use gamesgalaxy\Model\BearbeitenModel;
use gamesgalaxy\Model\LoginModel;
class BearbeitenController extends Controller
{
    public function actionShow()
    {

        if (!$this->isUserAuthenticated()) {
            echo "Du musst angemeldet sein um deine Daten zu bearbeiten";
        } else {

            $bearbeiten_view = new BearbeitenView();
            $bearbeiten_view->title = "Profil Bearbeiten";

            $userId = $_SESSION['user_id'];
            $bearbeiten_model = new BearbeitenModel();
            $userData = $bearbeiten_model->getUserDataById($userId);

            $bearbeiten_view->render_html('show', $userData);

        }
    }

    public function actionEdit()
    {
        if (!$this->isUserAuthenticated()) {
            echo "Du musst angemeldet sein um deine Daten zu bearbeiten";
        } else {
            $userId = $_SESSION['user_id'];

            $bearbeiten_model = new BearbeitenModel();
            $userData = $bearbeiten_model->getUserDataById($userId);

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['profile-submit'])) {

                $newUserName = $_POST['profile-name'];
                $newUserEmail = $_POST['profile-email'];
                $newPassword = $_POST['profile-new-password'];
                $confirmNewPassword = $_POST['profile-confirm-new-password'];
                $newAddress = $_POST['profile-address'];
                $newCity = $_POST['profile-city'];
                $currentPassword = $_POST['profile-current-password'];

                if (empty($newUserName) || empty($newUserEmail)) {
                    echo "Felder dürfen nicht leer sein.";
                } elseif (strlen($newUserName) > 255 || strlen($newUserEmail) > 255) {
                    echo "Die eingegebenen Daten sind zu lang.";
                } elseif (!filter_var($newUserEmail, FILTER_VALIDATE_EMAIL)) {
                    echo "Die eingegebene E-Mail-Adresse ist ungültig.";
                } else {

                    $loginModel = new LoginModel();
                    $currentPasswordIsValid = $loginModel->checkCredentials($userData['user_email'], $currentPassword);

                    if (!$currentPasswordIsValid) {
                        echo "Das aktuelle Passwort war falsch.";
                    } else {

                        $newStreet = $newStreetNumber = null;
                        if (!empty($newAddress))
                        {
                            $addressParts = explode(" ", $newAddress, 2);
                            $newStreet = $addressParts[0];
                            $newStreetNumber = $addressParts[1] ?? null;
                        }

                        $newPostalCode = $newCityName = null;
                        if (!empty($newCity))
                        {
                            $cityParts = explode(" ", $newCity, 2);
                            $newPostalCode = $cityParts[0];
                            $newCityName = $cityParts[1] ?? null;
                        }

                        if (!empty($newPassword) && $newPassword !== $confirmNewPassword) {
                            echo "Die neuen Passwörter stimmen nicht überein";
                        }

                        $bearbeitenModel = new BearbeitenModel();
                        $success = $bearbeitenModel->updateUserData($userId, $newUserName, $newUserEmail, $newPassword, $newStreet, $newStreetNumber, $newPostalCode, $newCityName);

                        if ($success) {
                            $_SESSION['user_name'] = $newUserName;
                            header("Location: /dwp_ws2324_rkt/gamesgalaxy/Startseite/Show");
                            exit();
                        } else {
                            echo "Fehler beim aktualisieren der Daten.";
                        }
                    }

                }

            }
        }
    }

}