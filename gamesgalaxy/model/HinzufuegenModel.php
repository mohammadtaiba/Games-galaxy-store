<?php

namespace gamesgalaxy\Model;

require_once __DIR__."/../model/Model.php";
require_once __DIR__."/../lib/DatabaseConnection.php";

use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;

class HinzufuegenModel extends Model
{
    private \mysqli $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::get_instance();
    }

    public function createGame($platform, $title, $price, $description, $key, $categories)
    {
        if (isset($_POST['addgame-submit']))
        {
            $createGameQuery = "INSERT INTO game (game_platform, game_name, game_price, game_description, game_key)
                                VALUES (?, ?, ?, ?, ?);";

            $statement = $this->db->prepare($createGameQuery);
            $statement->bind_param("sssss", $platform, $title, $price, $description, $key);
            $statement->execute();

            $gameId = $this->db->insert_id;

            $strategie = in_array('Strategy', $categories) ? 1 : 0;
            $action = in_array('Action', $categories) ? 1 : 0;
            $shooter = in_array('Shooter', $categories) ? 1 : 0;
            $rpg = in_array('RPG', $categories) ? 1 : 0;
            $simulation = in_array('Simulation', $categories) ? 1 : 0;

            $createCategoryQuery = "INSERT INTO category (game_id, Strategie, Action, Shooter, RPG, Simulation) 
                                VALUES (?, ?, ?, ?, ?, ?)";

            $statement = $this->db->prepare($createCategoryQuery);
            $statement->bind_param("iiiiii", $gameId, $strategie, $action, $shooter, $rpg, $simulation);
            $statement->execute();

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
