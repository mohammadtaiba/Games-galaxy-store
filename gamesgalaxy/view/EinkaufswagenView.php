<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
require_once __DIR__."/../model/EinkaufswagenModel.php";

use gamesgalaxy\Model\EinkaufswagenModel;

class EinkaufswagenView extends View
{
    static function show()
    {
        $einkaufswagen_model = new EinkaufswagenModel();
        $cartItems = $einkaufswagen_model->getCart();
        ?>

        <div id="titel-einkaufe">
            <p>Mein Warenkorb</p>
        </div>
        <div id="einkaufe-grid">
            <div class="flex-grid">

                <?php
                foreach ($cartItems as $item) {
                    $gameName = $item['game_name'] ?? 'Unbekanntes Spiel';
                    $price = $item['game_price'] ?? 'Unbekannter Preis';
                    $platform = $item['game_platform'] ?? 'Unbekannte Plattform';
                    $gameId = $item['game_id'] ?? 'Unbekannte ID';
                    ?>

                    <div class="wunschliste-grid-inhalt" data-game-id="<?php echo $gameId; ?>">
                        <div class="wunschliste-daten">
                            <div class="wunschliste-daten-inhalt">
                                <p class="wunschliste-uberschrift"><?php echo $gameName; ?></p>
                                <p><?php echo $price; ?> €</p>
                                <p><?php echo $platform; ?></p>
                            </div>
                        </div>
                        <div class="spiele-entfernen">
                            <form method="post" action="/dwp_ws2324_rkt/gamesgalaxy/Einkaufswagen/Remove">
                                <button type="submit" class="remove-element" name="remove_game_id" value="<?php echo $gameId; ?>">
                                    <i class="fa-solid fa-trash fa-xl"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <?php
                }
                if (isset($_SESSION['user_authenticated']) && $_SESSION['user_authenticated']) {
                    echo '<a class="borderless-link" href="/dwp_ws2324_rkt/gamesgalaxy/Checkout/Show"><div class="profile-dropdown-content-button">Zur Bezahlung</div></a>';
                } else {
                    echo '<p><a href="/dwp_ws2324_rkt/gamesgalaxy/Registrieren/Show" class="navbar-links">Jetzt registrieren und bequem bezahlen</a></p>';
                }
                ?>

            </div>

        </div>


        <?php
    }
}
