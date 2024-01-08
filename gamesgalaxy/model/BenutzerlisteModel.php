<?php

namespace gamesgalaxy\Model;

require_once __DIR__."/../model/Model.php";
require_once __DIR__."/../lib/DatabaseConnection.php";

use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;

class BenutzerlisteModel extends Model
{
    private \mysqli $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::get_instance();
    }

    public function get_all_users_except_current($currentUserId)
    {
        $query = "SELECT u.user_id, u.user_name, u.user_email, ua.address_street, ua.address_street_number, ua.address_city, ua.address_postalcode
        FROM user u LEFT JOIN user_address ua ON u.user_id = ua.user_id
        WHERE u.user_id <> ? ORDER BY u.user_id";

        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $currentUserId);
        $statement->execute();
        $result = $statement->get_result();

        $users = [];
        while ($row = $result->fetch_assoc())
        {
            $users[] = $row;
        }

        return $users;
    }

    public function delete_user($userId)
    {
        $this->db->begin_transaction();

        try
        {
            $addressQuery = "DELETE FROM user_address WHERE user_id = ?";
            $addressStatement = $this->db->prepare($addressQuery);
            $addressStatement->bind_param("i", $userId);
            $addressStatement->execute();

            $userQuery = "DELETE FROM user WHERE user_id = ?";
            $userStatement = $this->db->prepare($userQuery);
            $userStatement->bind_param('i', $userId);
            $userStatement->execute();

            $this->db->commit();
        } catch (\PDOException $exception) {
            $this->db->rollback();
            die("Löschen des Benutzers hat nicht geklappt weil: ".$exception->getMessage());
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

