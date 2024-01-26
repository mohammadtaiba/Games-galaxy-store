<?php

namespace gamesgalaxy\Model;

require_once __DIR__."/../model/Model.php";
require_once __DIR__."/../lib/DatabaseConnection.php";


use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;

class RegistrierenModel extends Model
{
    private \mysqli $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::get_instance();
    }

    function submit_userdata()
    {
        if (isset($_POST['registration-submit-button'])) {
            $UserName = \mysqli_real_escape_string($this->db, $_POST['UserName']);
            $UserEmail = \mysqli_real_escape_string($this->db, $_POST['UserEmail']);
            $UserPassword = \mysqli_real_escape_string($this->db, $_POST['UserPassword']);
            $UserConfirmPassword = \mysqli_real_escape_string($this->db, $_POST['UserConfirmPassword']);
            $UserAdress = \mysqli_real_escape_string($this->db, $_POST['UserAdress']);
            $UserTown = \mysqli_real_escape_string($this->db, $_POST['UserTown']);

            if ($UserPassword != $UserConfirmPassword)
            {
                echo "Die Passwörter stimmen nicht überein!";
                return;
            }

            $streetName = null;
            $houseNumber = null;
            if($UserAdress)
            {
                $adressParts = explode(" ", $UserAdress);
                $streetName = $adressParts[0];
                $houseNumber = $adressParts[1];
            }

            $postalCode = null;
            $cityName = null;
            if ($UserTown) {
                $townParts = explode(" ", $UserTown);
                $postalCode = $townParts[0];
                $cityName = $townParts[1];
            }

            $userSql = "INSERT INTO user (user_name, user_email, user_password) VALUES ('$UserName', '$UserEmail', '$UserPassword')";

            $userResult = $this->db->query($userSql);

            if($userResult) {
                $userId = $this->db->insert_id;

                $adressSql = "INSERT INTO user_address (user_id, address_street, address_street_number, address_postalcode, address_city) VALUES ('$userId', '$streetName', '$houseNumber', '$postalCode', '$cityName')";

                $adressResult = $this->db->query($adressSql);

                $authoritySql = "INSERT INTO user_authority (user_id, create_user, change_user, delete_user, create_game, change_game, delete_game) 
                                VALUES ('$userId', 1, 1, 0, 0, 0, 0)";

                $authorityResult = $this->db->query($authoritySql);

                if ($authorityResult) {
                        header("Location: /dwp_ws2324_rkt/gamesgalaxy/Startseite/Show");
                    } else {
                        echo "Fehler bei der Registrierung der Adresse oder Benutzerrechte: " . $this->db->error;
                    }
            } else {
                echo "Fehler bei der Registrierung des Benutzers" . $this->db->error;
            }
        }
    }

    function read()
    {

    }

    function create()
    {

    }

    function update()
    {

    }

    function delete()
    {

    }

    function read_all()
    {

    }

    function match_and_read(string $search_string)
    {

    }

    function delete_all()
    {

    }

}

