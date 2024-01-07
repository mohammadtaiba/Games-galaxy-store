<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class RegistrierenView extends View
{
    static function show()
    {
        echo <<<REGISTRIEREN
        <body>
<form class="register-container" method="post" action="/dwp_ws2324_rkt/gamesgalaxy/Registrieren/Submit">
    <div id="form-register-h1">
        <h1>Registrieren</h1>
    </div>

    <div class="form-register-group">
        <label for="register-name" class="register-label">Name</label>
        <input type="text" id="register-name" class="register-input" name="UserName" placeholder="Name eingeben (z.B. Max Musstermann)">
    </div>

    <div class="form-register-group">
        <label for="register-email" class="register-label">Email</label>
        <input type="email" id="register-email" class="register-input" name="UserEmail" placeholder="beispiel@example.com">
    </div>

    <div class="form-register-group">
        <label for="register-password" class="register-label">Passwort</label>
        <input type="password" id="register-password" class="register-input" name="UserPassword" placeholder="Passwort eingeben">
    </div>

    <div class="form-register-group">
        <label for="register-confirm-password" class="register-label">Passwort bestätigen</label>
        <input type="password" id="register-confirm-password" class="register-input" name="UserConfirmPassword" placeholder="Passwort bestätigen">
    </div>

    <div class="form-register-group">
        <label for="register-address" class="register-label">Straße und Hausnummer</label>
        <input type="text" id="register-address" class="register-input" name="UserAdress" placeholder="Straße und Hausnummer">
    </div>

    <div class="form-register-group">
        <label for="register-city" class="register-label">PLZ und Wohnort</label>
        <input type="text" id="register-city" class="register-input" name="UserTown" placeholder="PLZ und Wohnort">
    </div>

    <button type="submit" id="register-submit" name="registration-submit-button">Jetzt registrieren</button>
</form>
REGISTRIEREN;
    }
}

