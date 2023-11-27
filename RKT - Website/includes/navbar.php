<?php
echo <<< NAVBAR
<nav>
<div class="navigation">
    <div>
        <img src="Images/Logo.png" id="logo-img" alt="Das Logo von Games Galaxy">
    </div>
    <div id="brand-text">
        Games<br>
        Galaxy
    </div>
    <div id="nav-list">
        <a id="nav-element" href="uberuns.php">Über Uns</a>
        <div id="nav-dropdown">
            <button id="dropdown-button">Spiele<i class="fa-solid fa-down" style="color: #b1c2c7;"></i></button>
            <div id="dropdown-content">
                <a class="dropdown-element" href="#">Steam</a>
                <a class="dropdown-element" href="#">Battle.net</a>
                <a class="dropdown-element" href="#">Epic Games</a>
            </div>
        </div>
        <div id="search-box">
            <i class="fa-solid fa-magnifying-glass fa-xl" style="color: #000000;"></i>
            <input id="nav-search" type="text" placeholder="Suchen">
        </div>
    <div class="nav-icon">
        <a href><i class="fa-solid fa-user fa-xl" style="color: #000000;"></i></a>
    </div>
    <div class="nav-icon">
        <a href><i class="fa-solid fa-cart-shopping fa-xl" style="color: #000000;"></i></a>
    </div>
    </div>
</nav>
NAVBAR;
