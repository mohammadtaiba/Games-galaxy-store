<?php
$title = "registrieren";
require_once('includes/head.php');
require_once('includes/navbar.php');
?>

<body>
<form class="register-container">
    <div id="form-register-h1">
        <h1>Registrieren</h1>
    </div>

    <div class="form-register-group">
        <label for="register-name" class="register-label">Name</label>
        <input type="text" id="register-name" class="register-input" placeholder="Name eingeben (z.B. Max Musstermann)" required>
    </div>

    <div class="form-register-group">
        <label for="register-email" class="register-label">Email</label>
        <input type="email" id="register-email" class="register-input" placeholder="beispiel@example.com" required>
    </div>

    <div class="form-register-group">
        <label for="register-password" class="register-label">Passwort</label>
        <input type="password" id="register-password" class="register-input" placeholder="Passwort eingeben" required>
    </div>

    <div class="form-profile-group">
        <label for="profile-confirm-password" class="profile-label">Passwort bestätigen</label>
        <input type="password" id="profile-confirm-password" class="profile-input" placeholder="Passwort bestätigen" required>
    </div>

    <div class="form-register-group">
        <label for="register-address" class="register-label">Straße und Hausnummer</label>
        <input type="text" id="register-address" class="register-input" placeholder="Straße und Hausnummer" required>
    </div>

    <div class="form-register-group">
        <label for="register-city" class="register-label">PLZ und Wohnort</label>
        <input type="text" id="register-city" class="register-input" placeholder="PLZ und Wohnort" required>
    </div>

    <button type="submit" id="register-submit">Jetzt registrieren</button>
</form>

</body>
<?php
require_once('includes/footer.php');
?>
