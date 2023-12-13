<?php
session_start();

require_once('includes/login.php');

if (isset($_SESSION['conn']) && $_SESSION['conn'] instanceof mysqli) {
    $_SESSION['conn']->close();
    print "Datenbankverbindung geschlossen.";
} else {
    echo "Keine Datenbankverbindung gefunden.";
}
