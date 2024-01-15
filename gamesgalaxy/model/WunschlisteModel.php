<?php

namespace gamesgalaxy\Model;

require_once __DIR__."/../model/Model.php";
require_once __DIR__."/../lib/DatabaseConnection.php";

use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;

class WunschlisteModel extends Model
{
    private \mysqli $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::get_instance();
    }

    public function getWishlistByUserId($user_id)
    {
        $query = "SELECT * FROM wishlist WHERE user_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $user_id);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function addToWishlist($userId, $gameId)
    {
        $checkQuery = "SELECT * FROM wishlist WHERE user_id = ? AND game_id = ?";
        $checkStatement = $this->db->prepare($checkQuery);
        $checkStatement->bind_param("ii", $userId, $gameId);
        $checkStatement->execute();
        $checkResult = $checkStatement->get_result();

        if ($checkResult->num_rows > 0) {
            return false;
        }

        $insertQuery = "INSERT INTO wishlist (user_id, game_id) VALUES (?, ?)";
        $insertStatement = $this->db->prepare($insertQuery);
        $insertStatement->bind_param("ii", $userId, $gameId);

        return $insertStatement->execute();
    }

    public function removeFromWishlist($userId, $gameId)
    {
        $this->db->begin_transaction();

        try
        {
            $wishlistQuery = "DELETE FROM wishlist WHERE user_id = ? AND game_id = ?";
            $wishlistStatement = $this->db->prepare($wishlistQuery);
            $wishlistStatement->bind_param("ii", $userId, $gameId);
            $wishlistStatement->execute();

            $this->db->commit();
        } catch (\PDOException $exception) {
            $this->db->rollback();
            die("Entfernen des Spiels aus der Wunschliste hat nicht geklappt wegen: ".$exception->getMessage());
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

