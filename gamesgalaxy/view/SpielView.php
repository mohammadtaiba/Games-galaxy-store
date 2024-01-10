<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class SpielView extends View
{
    static function show()
    {
        echo <<<SPIEL

            <div class="spiel-flex">
                <div><img src="/dwp_ws2324_rkt/gamesgalaxy/images/guilty_gear_strive_cover.jpg" class="spiele-images" alt="Cover für das zweite Spiel"></div>
                <div class="kauf-infos">
                        <div id="spiel-name-flex">
                            <div id="spiel-name">Guilty Gear Strive  </div>
                        </div>
                        <div id="spiel-plattform">Steam</div>
                        <div id="spiel-preis">14.77€</div>
                        <div id="kauf-options-flex"><button id="warenkorb-hinzufuegen"><i class="fa-solid fa-cart-shopping"></i></button><button id="sofort-kauf">Sofort kaufen</button>  <button class="add-game-wishlist"> <i class="fa-solid fa-plus"></i></button> </div>
                </div>
            </div>
            <div>
                <div class="spiel-beschreibung">Beschreibung</div>
                <div id="spiel-beschreibung-text-flex">
                <div class="spiel-beschreibung-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum erat ipsum, vulputate quis dignissim a, hendrerit in eros. Ut tincidunt magna ac massa tincidunt sollicitudin. Nullam non pulvinar sapien, at elementum quam. Nullam bibendum placerat fringilla. Duis vel mollis metus. Phasellus et erat mauris. Aenean quis leo hendrerit, tristique quam ut, pulvinar nibh. Sed ut risus eu elit pharetra blandit. Quisque facilisis tincidunt dui. Nam vel dictum nunc, nec sodales purus. Vivamus semper metus a diam bibendum bibendum. Nam auctor felis leo, at sollicitudin sapien molestie sit amet. Etiam nec ex efficitur, faucibus nunc eget, bibendum leo. Sed in nibh enim. Praesent in quam egestas, sagittis magna eget, fringilla ligula. Ut vestibulum, lacus sit amet luctus sodales, sapien est pretium orci, nec posuere nisl erat eu sem.</div>
                </div>
            </div>
SPIEL;
    }
}