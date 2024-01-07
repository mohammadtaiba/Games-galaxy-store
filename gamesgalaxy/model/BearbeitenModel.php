<?php

namespace gamesgalaxy\Model;

require_once __DIR__."/../model/Model.php";
require_once __DIR__."/../lib/DatabaseConnection.php";

use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;

class BearbeitenModel extends Model
{
    private \mysqli $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::get_instance();
    }

    public function getUserDataById($userId)
    {
        $getUserById = $this->db->prepare("
        SELECT u.user_id, u.user_name, u.user_email,
        ua.address_id, ua.address_street, ua.address_street_number, ua.address_city, ua.address_postalcode
        FROM user u
        LEFT JOIN user_address ua ON u.user_id = ua.user_id
        WHERE u.user_id = ?");

        $getUserById->bind_param("i", $userId);

        $getUserById->execute();

        $result = $getUserById->get_result();

        if ($result && $result->num_rows > 0)
        {
            $userData = $result->fetch_assoc();
            return $userData;
        } else {
            return null;
        }
    }

    public function updateUserData($userId, $newUserName, $newUserEmail, $newPassword, $newStreet, $newStreetNumber, $newPostalCode, $newCityName)
    {
        $existingUserData = $this->getUserDataById($userId);

        if (!$existingUserData)
        {
            return false;
        }

        $updateUserQuery = $this->db->prepare("UPDATE user SET user_name = ?, user_email = ? WHERE user_id = ?");

        $updateUserQuery->bind_param("ssi", $newUserName, $newUserEmail, $userId);

        $userUpdateSuccess = $updateUserQuery->execute();

        if (!empty($newPassword))
        {
            $updatePasswordQuery = $this->db->prepare("UPDATE user SET user_password = ? WHERE user_id = ?");
            $updatePasswordQuery->bind_param("si", $newPassword, $userId);

            $passwordUpdateSuccess = $updatePasswordQuery->execute();
        } else {
            $passwordUpdateSuccess = true;
        }

        $updateAddressQuery = $this->db->prepare("UPDATE user_address SET address_street = ?, address_street_number = ?, address_city = ?, address_postalcode = ? WHERE user_id = ?");

        $updateAddressQuery->bind_param("ssssi", $newStreet, $newStreetNumber, $newCityName, $newPostalCode, $userId);

        $addressUpdateSuccess = $updateAddressQuery->execute();

        return $userUpdateSuccess && $passwordUpdateSuccess && $addressUpdateSuccess;
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