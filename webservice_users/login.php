<?php
require_once "connessione.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['username'], $data['password'])) {
        $username = $data['username'];
        $password = $data['password'];

        // Prepara la query per cercare l'utente
        $stmt = $myConn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                // Login riuscito
                echo json_encode([
                    "status" => "success",
                    "message" => "Login effettuato con successo"
                ]);
            } else {
                // Password errata
                echo json_encode([
                    "status" => "error",
                    "message" => "Password errata"
                ]);
            }
        } else {
            // Username non trovato
            echo json_encode([
                "status" => "error",
                "message" => "Utente non trovato"
            ]);
        }

        $stmt->close();
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Dati mancanti"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Metodo non consentito"
    ]);
}
?>
