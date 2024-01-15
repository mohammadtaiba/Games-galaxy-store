<?php

namespace gamesgalaxy\Model;

require_once __DIR__."/../model/Model.php";
require_once __DIR__."/../lib/DatabaseConnection.php";


use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;

class SpielModel extends Model
{
    private \mysqli $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::get_instance();
    }

    public function getGameById(int $game_id)
    {
        $query = "SELECT * FROM game WHERE game_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $game_id);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0)
        {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function getGamesByIds(array $gameIds)
    {
        $games = [];

        foreach ($gameIds as $gameId) {
            $game = $this->getGameById($gameId);

            if ($game) {
                $games[] = $game;
            }
        }

        return $games;
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
