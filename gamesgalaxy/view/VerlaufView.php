<?php

namespace gamesgalaxy\View;

require_once __DIR__ . "/../view/View.php";

class VerlaufView extends View
{
    static function show($orderHistory)
    {
        $orderHistory = array_reverse($orderHistory);

        echo <<<VERLAUF
<div id="verlauf-container">
    <h1 id="verlauf-title">Meine Einkäufe</h1>
VERLAUF;

        foreach ($orderHistory as $order) {
            $orderDate = $order['order_date'];
            $paymentMethod = $order['payment_method'];
            $orderTotal = $order['order_total'];

            echo <<<VERLAUF
<div class="history-data-summary-container">
    <div class="history-data-title">
        <p>$orderDate</p>
        <p>$paymentMethod</p>
        <p>$orderTotal €</p>
    </div>
VERLAUF;

            foreach ($order['order_items'] as $item) {
                $gameName = $item['game_name'];
                $gamePlatform = $item['game_platform'];
                $gamePrice = $item['game_price'];
                $gameKey = $item['game_key'];

                echo <<<VERLAUF
    <div class="checkout-history-summary-content">
        <p>$gameName</p>
        <p>$gamePlatform</p>
        <p>$gamePrice €</p>
        <p class="gamekey">$gameKey (Der Spielschlüssel wird bei der von ihnen ausgewählten Plattform eingelöst)</p>
    </div>
VERLAUF;
            }

            echo <<<VERLAUF
</div>
VERLAUF;
        }

        echo <<<VERLAUF
</div>
</body>
VERLAUF;
    }
}
?>
