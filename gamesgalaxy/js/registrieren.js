function validateForm(event) {
    event.preventDefault();

    let nameInput = document.getElementById("register-name");
    let nameError = document.getElementById("name-error");
    let nameRegex = /^[A-Za-z]+(?:\s[A-Za-z]+)+$/;

    let emailInput = document.getElementById("register-email");
    let emailError = document.getElementById("email-error");
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    let addressInput = document.getElementById("register-address");
    let addressError = document.getElementById("address-error");
    let addressRegex = /^[a-zA-ZäöüÄÖÜß]+\s\d+$/;

    let cityInput = document.getElementById("register-city");
    let cityError = document.getElementById("city-error");
    let cityRegex = /^\d{5}\s[A-Za-zäöüÄÖÜß\s]+$/;

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

    return true;
}
