<?php

namespace gamesgalaxy\Model;

require_once __DIR__."/../model/Model.php";
require_once __DIR__."/../lib/DatabaseConnection.php";


use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;

class LoginModel extends Model
{
    private \mysqli $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::get_instance();
    }

    public function checkCredentials($usermail, $password)
    {
        $checkUserInformation = "SELECT user_id, user_name FROM user WHERE user_email = '$usermail' AND user_password = '$password'";
        $result = $this->db->query($checkUserInformation);

        if ($result && $result->num_rows > 0)
        {
            $row = $result->fetch_assoc();

            $userId = $row['user_id'];
            $userAuthority = $this->getUserAuthority($userId);

            $_SESSION['user_authenticated'] = true;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_authority'] = $userAuthority;

            return true;
        } else {
            return false;
        }

    }

    private function getUserAuthority($userId)
    {
        $authoritySql = "SELECT * FROM user_authority WHERE user_id = '$userId'";
        $authorityResult = $this->db->query($authoritySql);

        if ($authorityResult && $authorityResult->num_rows > 0) {
            $authorityData = $authorityResult->fetch_assoc();

            return [
                'create_user' => $authorityData['create_user'],
                'change_user' => $authorityData['change_user'],
                'delete_user' => $authorityData['delete_user'],
                'create_game' => $authorityData['create_game'],
                'change_game' => $authorityData['change_game'],
                'delete_game' => $authorityData['delete_game'],
            ];
        } else {
            return [
                'create_user' => false,
                'change_user' => false,
                'delete_user' => false,
                'create_game' => false,
                'change_game' => false,
                'delete_game' => false,
            ];
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
