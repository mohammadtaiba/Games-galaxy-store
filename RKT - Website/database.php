<?php
session_start();

require_once('includes/login.php');

$_SESSION['conn'] = new mysqli('localhost', 'ggadmin','ggpassword','gg_dbms');

if ($_SESSION['conn']->connect_error) {
    die("Verbindung fehlgeschlagen: ".$_SESSION['conn']->connect_error);
}

$query = "SELECT 1";
$result = $_SESSION['conn']->query($query);

if ($result) {
    print "Verbindung zur Datenbank erfolgreich!";
} else {
    print "Error: ".$_SESSION['conn']->error;
}