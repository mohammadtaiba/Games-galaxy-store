<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class BearbeitenView extends View
{
    static function show($userData)
    {
        $userName = $userData['user_name'] ?? '';
        $userEmail = $userData['user_email'] ?? '';
        $street = $userData['address_street'] ?? '';
        $streetNumber = $userData['address_street_number'] ?? '';
        $postalCode = $userData['address_postalcode'] ?? '';
        $city = $userData['address_city'] ?? '';

        $userAddress = ("$street $streetNumber");
        $userCity = ("$postalCode $city");

        echo <<<BEARBEITEN

<form class="profile-container" method="post" enctype="multipart/form-data" action="/dwp_ws2324_rkt/gamesgalaxy/Bearbeiten/Edit">
    <div id="form-profile-h1">
        <h1>Profil bearbeiten</h1>
    </div>

    <div class="form-profile-group">
        <label for="profile-name" class="profile-label">Name</label>
        <input type="text" id="profile-name" name="profile-name" class="profile-input" placeholder="Vollständiger Name" value="$userName">
    </div>

    <div class="form-profile-group">
        <label for="profile-email" class="profile-label">Email</label>
        <input type="email" id="profile-email" name="profile-email" class="profile-input" placeholder="beispiel@example.com" value="$userEmail">
    </div>

    <div class="form-profile-group">
        <label for="profile-new-password" class="profile-label">Neues Passwort(Optional)</label>
        <input type="password" id="profile-new-password" name="profile-new-password" class="profile-input" placeholder="Neues Passwort">
    </div>

    <div class="form-profile-group">
        <label for="profile-confirm-new-password" class="profile-label">Passwort bestätigen</label>
        <input type="password" id="profile-confirm-new-password" name="profile-confirm-new-password" class="profile-input" placeholder="Neues Passwort bestätigen">
    </div>

    <div class="form-profile-group">
        <label for="profile-address" class="profile-label">Straße und Hausnummer</label>
        <input type="text" id="profile-address" name="profile-address" class="profile-input" placeholder="Straße und Hausnummer" value="$userAddress">
    </div>

    <div class="form-profile-group">
        <label for="profile-city" class="profile-label">PLZ und Wohnort</label>
        <input type="text" id="profile-city" name="profile-city" class="profile-input" placeholder="PLZ und Wohnort" value="$userCity">
    </div>
    
    <div class="form-profile-group">
        <label for="profile-current-password" class="profile-label">Passwort</label>
        <input type="password" id="profile-current-password" name="profile-current-password" class="profile-input" placeholder="Aktuelles Passwort" required>
    </div>

    <button type="submit" id="profile-submit" name="profile-submit">Änderung Speichern</button>
</form>

</body>
BEARBEITEN;
    }
}

