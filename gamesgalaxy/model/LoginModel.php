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

            $_SESSION['user_authenticated'] = true;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            return true;
        } else {
            return false;
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
