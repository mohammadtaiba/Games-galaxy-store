<?php

namespace gamesgalaxy\Model;

require_once __DIR__."/../model/Model.php";
require_once __DIR__."/../lib/DatabaseConnection.php";

use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;

class CheckoutModel extends Model
{
    private \mysqli $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::get_instance();
    }

    public function getCartItems($userId)
    {
        $query = "SELECT game.game_id, game.game_name, game.game_platform, game.game_price 
                  FROM cart_item 
                  JOIN game ON cart_item.game_id = game.game_id 
                  WHERE cart_item.user_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $userId);
        $statement->execute();
        $result = $statement->get_result();

        $cartItems = [];
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }

        return $cartItems;
    }

    public function getUserData($userId)
    {
        $query = "SELECT user_name, user_email, address_street, address_street_number, address_postalcode, address_city
                  FROM user
                  LEFT JOIN user_address ON user.user_id = user_address.user_id
                  WHERE user.user_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $userId);
        $statement->execute();
        $result = $statement->get_result();

        $userData = $result->fetch_assoc();

        return $userData;
    }

    public function saveOrder($userId, $cartItems, $userData, $paymentMethod)
    {
        $prices = array_map(function ($item) {
            return floatval(str_replace(',', '.', $item['game_price']));
        }, $cartItems);

        $subtotal = array_sum($prices);
        $taxRate = 0.19;
        $taxAmount = $subtotal * $taxRate;
        $total = $subtotal + $taxAmount;

        $totalFormatted = number_format($total, 2, ',', '');

        $query = "INSERT INTO order_data (user_id, order_total, order_date, payment_method)
              VALUES (?, ?, NOW(), ?)";
        $statement = $this->db->prepare($query);

        $statement->bind_param("iss", $userId, $totalFormatted, $paymentMethod);

        $statement->execute();
        $orderId = $statement->insert_id;

        foreach ($cartItems as $item) {
            $query = "INSERT INTO order_items (order_id, game_id)
                  VALUES (?, ?)";
            $statement = $this->db->prepare($query);
            $statement->bind_param("ii", $orderId, $item['game_id']);
            $statement->execute();
        }
    }

    public function clearCartItems($userId)
    {
        $query = "DELETE FROM cart_item WHERE user_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $userId);
        $statement->execute();
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

