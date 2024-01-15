<?php

namespace gamesgalaxy\Model;

require_once __DIR__."/../model/Model.php";
require_once __DIR__."/../lib/DatabaseConnection.php";


use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class EinkaufswagenModel extends Model
{
    private \mysqli $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::get_instance();
    }

    public function removeFromCart($gameId)
    {
        $gameId = (int)$gameId;
        $this->db->begin_transaction();

        try {
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                $deleteQuery = "DELETE FROM cart_item WHERE user_id = ? AND game_id = ?";
                $deleteStatement = $this->db->prepare($deleteQuery);
                $deleteStatement->bind_param("ii", $userId, $gameId);
                $deleteStatement->execute();
            } else {
                if (isset($_SESSION['temp_cart'][$gameId])) {
                    unset($_SESSION['temp_cart'][$gameId]);
                }
            }

            $this->db->commit();
            return true;
        } catch (\Exception $exception) {
            $this->db->rollback();
            error_log("Fehler beim Entfernen des Spiels aus dem Warenkorb: " . $exception->getMessage());
            return false;
        }
    }

    private function isGameInCart($userId, $gameId)
    {
        $query = "SELECT COUNT(*) as count FROM cart_item WHERE user_id = ? AND game_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("ii", $userId, $gameId);
        $statement->execute();
        $result = $statement->get_result();
        $row = $result->fetch_assoc();

        return $row['count'] > 0;
    }

    public function addToCart($gameId)
    {
        $gameId = (int)$gameId;
        $this->db->begin_transaction();

        try {
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                $isGameInCart = $this->isGameInCart($userId, $gameId);

                if (!$isGameInCart) {
                    $insertQuery = "INSERT INTO cart_item (user_id, game_id) VALUES (?, ?)";
                    $insertStatement = $this->db->prepare($insertQuery);
                    $insertStatement->bind_param("ii", $userId, $gameId);
                    $insertStatement->execute();
                }
                $this->transferTempCartToDatabase($userId);
            } else {
                if (!isset($_SESSION['temp_cart'])) {
                    $_SESSION['temp_cart'] = [];
                }

                $gameId = (int)$gameId;

                if (isset($_SESSION['temp_cart'][$gameId])) {
                    $this->db->commit();
                    return 'Das Spiel ist bereits in Ihrem Einkaufswagen.';
                }

                $_SESSION['temp_cart'][$gameId] = 1;
            }

            $this->db->commit();
            return true;
        } catch (\Exception $exception) {
            $this->db->rollback();
            error_log("Fehler beim Hinzufügen zum Einkaufswagen: " . $exception->getMessage());
            return false;
        }
    }

    public function transferTempCartToDatabase($userId)
    {
        if (isset($_SESSION['temp_cart']) && !empty($_SESSION['temp_cart'])) {
            foreach ($_SESSION['temp_cart'] as $gameId) {
                $insertQuery = "INSERT INTO cart_item (user_id, game_id) VALUES (?, ?)";
                $insertStatement = $this->db->prepare($insertQuery);
                $insertStatement->bind_param("ii", $userId, $gameId);
                $insertStatement->execute();
            }

            unset($_SESSION['temp_cart']);
        }
    }

    public function getCart()
    {
        $cartItems = [];

        if (isset($_SESSION['temp_cart']) && !empty($_SESSION['temp_cart'])) {
            foreach ($_SESSION['temp_cart'] as $gameId) {
                $gameDetails = $this->getGameDetails($gameId);

                if ($gameDetails) {
                    $cartItems[] = [
                        'game_id' => $gameId,
                        'game_name' => $gameDetails['game_name'],
                        'game_price' => $gameDetails['game_price'],
                        'game_platform' => $gameDetails['game_platform'],
                    ];
                }
            }
        }

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $query = "SELECT c.game_id, g.game_name, g.game_price, g.game_platform
                  FROM cart_item c
                  JOIN game g ON c.game_id = g.game_id
                  WHERE c.user_id = ?";
            $statement = $this->db->prepare($query);
            $statement->bind_param("i", $userId);
            $statement->execute();
            $result = $statement->get_result();

            while ($row = $result->fetch_assoc()) {
                $cartItems[] = $row;
            }
        }

        return $cartItems;
    }

    private function getGameDetails($gameId)
    {
        $query = "SELECT game_name, game_price, game_platform FROM game WHERE game_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $gameId);
        $statement->execute();
        $result = $statement->get_result();

        return $result->fetch_assoc();
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

