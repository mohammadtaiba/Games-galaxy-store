<?php

namespace gamesgalaxy\Model;

require_once __DIR__."/../model/Model.php";
require_once __DIR__."/../lib/DatabaseConnection.php";

use gamesgalaxy\lib\DatabaseConnection\DatabaseConnection;

class VerlaufModel extends Model
{
    private \mysqli $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::get_instance();
    }

    public function getOrderHistory($userId)
    {
        $query = "SELECT od.*, oi.*, g.* FROM order_data od
                  JOIN order_items oi ON od.order_id = oi.order_id
                  JOIN game g ON oi.game_id = g.game_id
                  WHERE od.user_id = ?";

        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $userId);
        $statement->execute();
        $result = $statement->get_result();

        $historyData = [];

        while ($row = $result->fetch_assoc()) {
            $orderId = $row['order_id'];

            if (!isset($historyData[$orderId])) {
                $paymentMethod = strtolower($row['payment_method']);
                $formattedPaymentMethod = ucfirst($paymentMethod);

                $historyData[$orderId] = [
                    'order_date' => $row['order_date'],
                    'payment_method' => $formattedPaymentMethod,
                    'order_items' => [],
                    'order_total' => $row['order_total']
                ];
            }

            $historyData[$orderId]['order_items'][] = [
                'game_name' => $row['game_name'],
                'game_platform' => $row['game_platform'],
                'game_price' => $row['game_price']
            ];
        }

        return array_values($historyData);
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