<?php
require_once "connessione.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);//prende i dati inviati da postman 

    if (isset($data['username'], $data['password'], $data['email'])) {
        $username = $data['username'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $email = $data['email'];

        // Controlla se l'username esiste già
        $check = $myConn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);//s singifica stringa da inserire nel segnaposto ?
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "Username già esistente"]);
        } else {
            $stmt = $myConn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");//prepara la query con i dati da inserire che arrivano da postman
            $stmt->bind_param("sss", $username, $password, $email);// sss al posto di ??? metti le stringhe 

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Registrazione completata"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Errore nella registrazione"]);
            }
        }

        $check->close();
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid data"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Metodo non consentito"]);
}
?>


