<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo json_encode([
        "status" => "success",
        "message" => "Logout effettuato con successo"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Metodo non consentito"
    ]);
}
?>
