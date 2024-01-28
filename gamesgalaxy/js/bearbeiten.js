function validateBearbeitenForm() {
    let nameInput = document.getElementById("profile-name");
    let nameError = document.getElementById("name-error");
    let nameRegex = /^[A-Za-z]+(?:\s[A-Za-z]+)+$/;

    let emailInput = document.getElementById("profile-email");
    let emailError = document.getElementById("email-error");
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    let newPasswordInput = document.getElementById("profile-new-password");
    let confirmPasswordInput = document.getElementById("profile-confirm-new-password");
    let newPasswordError = document.getElementById("new-password-error");

    let addressInput = document.getElementById("profile-address");
    let addressError = document.getElementById("address-error");
    let addressRegex = /^[a-zA-ZäöüÄÖÜß]+\s\d+$/;

    let cityInput = document.getElementById("profile-city");
    let cityError = document.getElementById("city-error");
    let cityRegex = /^\d{5}\s[A-Za-zäöüÄÖÜß\s]+$/;

    let currentPasswordInput = document.getElementById("profile-current-password");
    let currentPasswordError = document.getElementById("current-password-error");

    if (!nameRegex.test(nameInput.value.trim())) {
        nameError.textContent = "Bitte geben Sie den Namen im Format 'Vorname Nachname' ein.";
        return false;
    } else {
        nameError.textContent = "";
    }

    if (!emailRegex.test(emailInput.value.trim())) {
        emailError.textContent = "Bitte geben Sie eine gültige E-Mail-Adresse ein.";
        return false;
    } else {
        emailError.textContent = "";
    }

    if (newPasswordInput.value.trim() !== confirmPasswordInput.value.trim()) {
        newPasswordError.textContent = "Die Passwörter stimmen nicht überein.";
        return false;
    } else {
        newPasswordError.textContent = "";
    }

    if (!addressRegex.test(addressInput.value.trim())) {
        addressError.textContent = "Bitte geben Sie die Adresse im Format 'Straßenname Hausnummer' ein.";
        return false;
    } else {
        addressError.textContent = "";
    }

    if (!cityRegex.test(cityInput.value.trim())) {
        cityError.textContent = "Bitte geben Sie die PLZ und den Wohnort im Format 'Postleitzahl Stadtname' ein.";
        return false;
    } else {
        cityError.textContent = "";
    }

    if (currentPasswordInput.value.trim() === '') {
        currentPasswordError.textContent = "Bitte geben Sie Ihr aktuelles Passwort ein.";
        return false;
    } else {
        currentPasswordError.textContent = "";
    }

    return true;
}
