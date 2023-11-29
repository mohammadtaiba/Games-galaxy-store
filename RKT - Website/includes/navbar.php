<?php
echo <<< NAVBAR
<nav>
    <div id="brand">
        <a href="/"><img src="Images/Logo.png" id="gglogo" alt="Das Logo von Games Galaxy"></a>
        <a href="/"><p>Games<br>Galaxy<p></a>
    </div>
    <div id="nav-menu">
        <ul>
            <li><a href="/">Über Uns</a></li>
            <li><a href="/">Spiele</a></li>
        </ul>
    </div>
    <div id="searchbar">
        <i class="fa-solid fa-magnifying-glass fa-xl"></i>
        <input type="text" placeholder="Suchen">
    </div>
    <div class="dropdown-icon">
        <a href="/"><i class="fa-solid fa-user fa-xl"></i></a>
    </div>
    <div class="dropdown-icon"">
        <a href="/"><i class="fa-solid fa-cart-shopping fa-xl"></i></a>
    </div>

    <div id="hamburger-icon" onclick="toggleMobileMenu(this)">
        <div id="bar1"></div>
        <div id="bar2"></div>
        <div id="bar3"></div>
        <ul id="hamburger-menu">
            <li><a href="/">Über Uns</a></li>
            <li><a href="/">Spiele</a></li>
        </ul>
    </div>
</nav>
NAVBAR;