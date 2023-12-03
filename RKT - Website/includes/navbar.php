<!--Falko Kühn start-->
<?php
echo <<< NAVBAR
<nav>
    <div id="brand">
        <a href="startseite.php"><img src="Images/Logo.png" id="gglogo" alt="Das Logo von Games Galaxy"></a>
        <a href="startseite.php" class="navbar-links"><p>Games<br>Galaxy<p></a>
    </div>
    <div id="nav-menu">
        <ul>
            <li><a href="uberuns.php" class="navbar-links">Über Uns</a></li>
            <div class="navbar-dropdown">
                <li><button class="navbar-dropdown-button">Spiele</button></li>
                <div class="navbar-dropdown-content">
                    <p><a href="steamspiele.php" class="navbar-links">Steam</a></p>
                    <p><a href="battlenetspiele.php" class="navbar-links">Battle.net</a></p>
                    <p><a href="epicspiele.php" class="navbar-links">Epic Games</a></p>
                </div>
            </div>
        </ul>
    </div>
    <div id="searchbar">
        <i class="fa-solid fa-magnifying-glass fa-xl"></i>
        <input type="text" placeholder="Suchen">
    </div>
    <div class="dropdown-icon">
        <div id="profile-dropdown">
            <button class="navbar-icon-button"><i class="fa-solid fa-user fa-xl"></i></button>
            <div id="profile-dropdown-content">
                <p>Super Mario</p>
                <a href="einkaufe.php"><button class="profile-dropdown-content-button">Meine Einkäufe</button></a>
                <a href="wunschliste.php"><button class="profile-dropdown-content-button">Wunschliste</button></a>
                <a href="profilbearbeiten.php"><button class="profile-dropdown-content-button">Profil bearbeiten</button></a>
                <a href="/" class="navbar-links">Abmelden</a>
            </div>
        </div> 
    </div>
    <div class="dropdown-icon">
        <div id="cart-dropdown">
            <button class="navbar-icon-button"><i class="fa-solid fa-cart-shopping fa-xl"></i></button>
            <div id="cart-dropdown-content">
                <a href="checkout.php"><button class="profile-dropdown-content-button">Zur Bezahlung</button></a>
            </div>
        </div>
    </div>

    <div id="hamburger-icon" onclick="toggleMobileMenu(this)">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <ul id="hamburger-menu">
            <li><a href="/" class="navbar-links">Über Uns</a></li>
            <div class="navbar-dropdown">
                <li><button class="navbar-dropdown-button">Spiele</button></li>
                <div class="navbar-dropdown-content-small">
                    <p><a href="steamspiele.php" class="navbar-links">Steam</a></p>
                    <p><a href="battlenetspiele.php" class="navbar-links">Battle.net</a></p>
                    <p><a href="epicspiele.php" class="navbar-links">Epic Games</a></p>
                </div>
            </div>
            <li><a href="kontakt.php" class="navbar-links">Kontaktiere uns</a></li>
            <li><a href="faq.php" class="navbar-links">FAQ</a></li>
        </ul>
    </div>
</nav>
NAVBAR;
?>
<!--Falko Kühn ende->>
