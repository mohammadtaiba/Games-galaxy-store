<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class BenutzerlisteView extends View
{
    static function show($users)
    {
        echo <<<BENUTZERLISTE
        
            <div id="titel-einkaufe">
                <p>Benutzerliste</p>
            </div>
            <div id="einkaufe-grid">
                <div class="flex-grid">
BENUTZERLISTE;
                    foreach ($users as $user) {
                        echo '<div class="benutzer-profil">';
                        echo '    <div class="wunschliste-grid-inhalt">';
                        echo '        <div class="wunschliste-daten">';
                        echo '            <div class="wunschliste-daten-inhalt">';
                        echo '                <p class="wunschliste-uberschrift">' . $user['user_name'] . '</p>';
                        echo '                <p>' . $user['user_email'] . '</p>';

                        if ($user['address_street'] !== 0 && $user['address_street_number'] !== 0)
                        echo '                <p>' . $user['address_street'] . ' ' . $user['address_street_number'] . '</p>';

                        if ($user['address_postalcode'] !== 0 && $user['address_city'] !== 0)
                        echo '                <p>' . $user['address_postalcode'] . ' ' . $user['address_city'] . '</p>';

                        echo '            </div>';
                        echo '        </div>';
                        echo '        <div class="spiele-entfernen">';
                        echo '        <form method="post" action="/dwp_ws2324_rkt/gamesgalaxy/Benutzerliste/DeleteUser">';
                        echo '        <input type="hidden" name="user_id" value="' . $user['user_id'] . '">';
                        echo '            <button type="submit" class="remove-element" onclick="return confirm(\'Benutzer wirklich löschen?\')"><i class="fa-solid fa-trash fa-xl"></i></button>';
                        echo '        </div>';
                        echo '    </div>' ;
                        echo '</div>';
                    }

                    echo <<< BENUTZERLISTE
                </div>
            </div>          
        </body>
BENUTZERLISTE;
    }
}

