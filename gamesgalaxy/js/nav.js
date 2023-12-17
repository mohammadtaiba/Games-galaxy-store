function  toggleHamburgerMenu() {
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


function toggleCartMenu() {
    let dropdownCart = document.getElementById("cart-dropdown");
    dropdownCart.classList.toggle("cart-active");
}