function  toggleHamburgerMenu() {
    var dropdownHamburger = document.getElementById("hamburger-menu");
    dropdownHamburger.classList.toggle("active");
}

function toggleSpieleDropdown() {
    var dropdownSpiele = document.getElementById("navbar-spiele-dropdown");
    dropdownSpiele.classList.toggle("active");
}

function toggleSmallSpieleDropdown() {
    var dropdownSpieleSmall = document.getElementById("navbar-small-spiele-dropdown");
    dropdownSpieleSmall.classList.toggle("nested-active");
}

function toggleProfileMenu() {
    var dropdownProfile = document.getElementById("profile-dropdown");
    dropdownProfile.classList.toggle("profile-active");

    var allDropdowns = document.querySelectorAll('hamburger-menu')
}


function toggleCartMenu() {
    var dropdownCart = document.getElementById("cart-dropdown");
    dropdownCart.classList.toggle("cart-active");
}

