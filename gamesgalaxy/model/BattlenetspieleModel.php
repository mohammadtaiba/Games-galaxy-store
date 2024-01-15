<?php

namespace gamesgalaxy\Model;

require_once __DIR__."/../model/Model.php";
require_once __DIR__."/../lib/DatabaseConnection.php";

use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;

class BattlenetspieleModel extends Model
{
    private \mysqli $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::get_instance();
    }

    public function getAllGamesWithCategories($sortOption = null, $filterCategory = null)
    {
        $query = "SELECT g.game_id, g.game_name, g.game_price, g.game_platform,
                    GROUP_CONCAT(
                    DISTINCT 
                    CONCAT_WS(', ',
                    CASE WHEN c.Strategie = 1 THEN 'Strategie' ELSE NULL END,
                    CASE WHEN c.Action = 1 THEN 'Action' ELSE NULL END,
                    CASE WHEN c.Shooter = 1 THEN 'Shooter' ELSE NULL END,
                    CASE WHEN c.RPG = 1 THEN 'RPG' ELSE NULL END,
                    CASE WHEN c.Simulation = 1 THEN 'Simulation' ELSE NULL END
                    )
                    ) AS category_names
                    FROM game g LEFT JOIN category c ON g.game_id = c.game_id WHERE g.game_platform = 'Battle.net'";

        if (!empty($filterCategory) && $filterCategory !== 'all') {
            $query .= " AND '$filterCategory' IN (c.Strategie, c.Action, c.Shooter, c.RPG, c.Simulation)";
        }

        $query .= " GROUP BY g.game_id";

        if (!empty($sortOption)) {
            switch ($sortOption) {
                case 'game-name-ascending':
                    $query .= " ORDER BY g.game_name ASC";
                    break;

                case 'game-name-descending':
                    $query .= " ORDER BY g.game_name DESC";
                    break;

                case 'game-price-ascending':
                    $query .= " ORDER BY g.game_price ASC";
                    break;

                case 'game-price-descending':
                    $query .= " ORDER BY g.game_price DESC";
                    break;
            }
        }

        $result = $this->db->query($query);

        if (!$result) {
            die("Fehler beim Datenbankaufruf: " . $this->db->error);
        }

        $games = [];
        while ($row = $result->fetch_assoc()) {

            if (isset($row['game_name'], $row['game_price'], $row['category_names'])) {
                $game = [
                    'game_id' => $row['game_id'],
                    'game_name' => $row['game_name'],
                    'game_price' => $row['game_price'],
                    'game_platform' => $row['game_platform'],
                    'category_names' => explode(', ', $row['category_names'])
                ];

                $games[] = $game;

            } else {
                $games[] = [
                    'game_name' => 'Ungültiger Spielname',
                    'game_price' => 'Ungültiger Preis',
                    'category_names' => ['Ungültige Kategorien']
                ];
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

