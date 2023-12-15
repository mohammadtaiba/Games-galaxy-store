<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class BearbeitenView extends View
{
    static function show()
    {
        echo <<<BEARBEITEN
        <body>

<form class="profile-container" method="post" enctype="multipart/form-data">
    <div id="form-profile-h1">
        <h1>Profil bearbeiten</h1>
    </div>

    <div class="form-profile-group">
        <label for="profile-name" class="profile-label">Name</label>
        <input type="text" id="profile-name" class="profile-input" placeholder="Vollständiger Name" required>
    </div>

    <div class="form-profile-group">
        <label for="profile-email" class="profile-label">Email</label>
        <input type="email" id="profile-email" class="profile-input" placeholder="beispiel@example.com" required>
    </div>

    <div class="form-profile-group">
        <label for="profile-current-password" class="profile-label">Passwort</label>
        <input type="password" id="profile-current-password" class="profile-input" placeholder="Aktuelles Passwort" required>
    </div>

    <div class="form-profile-group">
        <label for="profile-new-password" class="profile-label">Neues Passwort(Optional)</label>
        <input type="password" id="profile-new-password" class="profile-input" placeholder="Neues Passwort">
    </div>

    <div class="form-profile-group">
        <label for="profile-confirm-new-password" class="profile-label">Passwort bestätigen</label>
        <input type="password" id="profile-confirm-new-password" class="profile-input" placeholder="Neues Passwort bestätigen">
    </div>

    <div class="form-profile-group">
        <label for="profile-address" class="profile-label">Straße und Hausnummer</label>
        <input type="text" id="profile-address" class="profile-input" placeholder="Straße und Hausnummer" required>
    </div>

    <div class="form-profile-group">
        <label for="profile-city" class="profile-label">PLZ und Wohnort</label>
        <input type="text" id="profile-city" class="profile-input" placeholder="PLZ und Wohnort" required>
    </div>

    <button type="submit" id="profile-submit">Änderung Speichern</button>
</form>

</body>
BEARBEITEN;
    }
}

