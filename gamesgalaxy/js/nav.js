function  toggleHamburgerMenu() {
    console.log("Toggle Hamburger Menu");
    let dropdownHamburger = document.getElementById("hamburger-menu");
    dropdownHamburger.classList.toggle("active");
}

function toggleSpieleDropdown() {
    let dropdownSpiele = document.getElementById("navbar-spiele-dropdown");
    dropdownSpiele.classList.toggle("active");
}

function toggleSmallSpieleDropdown() {
    let dropdownSpieleSmall = document.getElementById("navbar-small-spiele-dropdown");
    dropdownSpieleSmall.classList.toggle("nested-active");
}

function toggleProfileMenu() {
    let dropdownProfile = document.getElementById("profile-dropdown");
    dropdownProfile.classList.toggle("profile-active");
}

function closeOtherDropdowns(currentDropdownId) {
    let otherDropdowns = ["hamburger-menu", "navbar-spiele-dropdown", "navbar-small-spiele-dropdown", "profile-dropdown"];

    otherDropdowns.forEach(function(dropdownId) {
        if (dropdownId !== currentDropdownId) {
            let otherDropdown = document.getElementById(dropdownId);
            if (otherDropdown && otherDropdown.classList.contains("active")) {
                otherDropdown.classList.remove("active");
            }
            if (otherDropdown && otherDropdown.classList.contains("nested-active")) {
                otherDropdown.classList.remove("nested-active");
            }
            if (otherDropdown && otherDropdown.classList.contains("profile-active")) {
                otherDropdown.classList.remove("profile-active");
            }
        }
    });
}

function logout() {
    window.location.href = '/dwp_ws2324_rkt/gamesgalaxy/Login/Logout';
}