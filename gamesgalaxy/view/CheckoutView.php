<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class CheckoutView extends View
{
    static function show($data)
    {
        $cartItems = $data['cartItems'] ?? [];
        $userData = $data['userData'] ?? [];

        $prices = array_map(function ($item) {
            return floatval(str_replace(',', '.', $item['game_price']));
        }, $cartItems);

        $subtotal = array_sum($prices);

        $taxRate = 0.19;
        $taxAmount = $subtotal * $taxRate;

        $total = $subtotal + $taxAmount;

        $subtotalFormatted = number_format($subtotal, 2, ',', '.');
        $taxAmountFormatted = number_format($taxAmount, 2, ',', '.');
        $totalFormatted = number_format($total, 2, ',', '.');

        echo <<<CHECKOUT
    <div id="checkout-container">
        <h1 id="checkout-title">Checkout</h1>
        <div id="checkout-grid">
            <div id="checkout-data">
                <div class="checkout-data-title">
                    <p>Zusammenfassung</p>
                </div>
                <div class="checkout-data-summary-container">
                    <div class="checkout-data-summary">
CHECKOUT;
                    foreach ($cartItems as $item)
                    {
                        echo '<div class="checkout-data-summary-content">';
                        echo    '<p>' . $item['game_name'] . '</p>';
                        echo    '<p>' . $item['game_platform'] . '</p>';
                        echo    '<p>' . $item['game_price'] . ' €</p>';
                        echo '</div>';
                    }

                    echo <<< CHECKOUT
                    </div>
                </div>
                <div class="checkout-data-summary">
                    <div class="checkout-data-summary-table">
                        <table>
                        <tbody>
                            <tr>
                                <td><p>Zwischensumme</p></td>
                                <td><p>{$subtotalFormatted} €</p></td>
                            </tr>
                            <tr>
                                <td>Mehrwertsteuer 19%</td>
                                <td>{$taxAmountFormatted} €</td>
                            </tr>
                            <tr>
                                <td>Gesamt</td>
                                <td>{$totalFormatted} €</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="checkout-payment">
                <div class="checkout-billing-adress-title">
                    <p>Rechnungsadresse</p>
                </div>
                <div class="checkout-billing-adress">
                    <div class="checkout-billing-adress-content">
                        <p>{$userData['user_name']}</p>
                        <p>{$userData['address_street']} {$userData['address_street_number']}</p>
                        <p>{$userData['address_postalcode']} {$userData['address_city']}</p>
                    </div>
                </div>
                <div id="checkout-payment-method">
                    <div class="checkout-billing-adress-title">
                        <p>Zahlungsmethoden</p>
                    </div>
                    <div class="checkout-payment-method">
                        <div class="checkout-payment-method-checkbox">
                            <input type="radio" class="payment-method-checkbox" name="payment-checkbox">
                        </div>
                        <div class="checkout-payment-method-content">
                            <p>Paypal</p><br>
                            <p>{$userData['user_email']}</p>
                        </div>   
                    </div>
                    <div class="checkout-payment-method">
                        <div class="checkout-payment-method-checkbox">
                            <input type="radio" class="payment-method-checkbox" name="payment-checkbox" checked>
                        </div>
                        <div class="checkout-payment-method-content">
                            <p>Rechnung</p><br>
                            <p>{$userData['user_name']}</p>
                        </div>   
                    </div>
                <form>
                   <button type="submit" id="checkout-button" name="checkout-button">Jetzt Bezahlen</button>
                </form>
                </div>
            </div>
        </div>
    </div></body>
CHECKOUT;
    }
}

