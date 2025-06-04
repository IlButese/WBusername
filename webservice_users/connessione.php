<?php
$username = "root";
$password = "";
$host = "localhost";
$dbName = "webservice_users";

// Connessione al server MySQL 
$myConn = new mysqli($host, $username, $password);

// Controllo errore di connessione
if ($myConn->connect_error) {
    die("Connessione fallita: " . $myConn->connect_error);
} else {
    echo "Connesso con successo. Info: " . $myConn->host_info . " - " . $myConn->server_info . "<br>";
}
// Selezione del database
if ($myConn->select_db($dbName)) {
    echo "Database selezionato.<br>";
} else {
    echo "Errore nella selezione del database: " . $myConn->error . "<br>";
}
?>
