<?php
require $_SERVER["DOCUMENT_ROOT"] . "chaliwhat/source/server/databaseService/DatabaseService.php";
require $_SERVER["DOCUMENT_ROOT"] . "chaliwhat/source/server/jws/vendor/autoload.php";

use \Firebase\JWT\JWT;

$params = json_decode(file_get_contents("php://input"), true);

header("Content-type: application/json");

if (isset($params["username"]) && $params["username"] != "" && (isset($params["password"]) && $params["password"] != "")) {
    $username = $params["username"];
    $password = hash("sha256", $params["password"]);

    $dbService = new DatabaseService("localhost", "root", "", "chaliwhat");
    $db = $dbService->getConnection();
    try {
        // to get information about the logging in user, to attach them in JWT payload
        // this is useful to not always send user's information from client to server but keep them in a defined place
        $query = "SELECT id, nome, username, password FROM utenti WHERE (username = \"" . $username . "\" OR email = \"" . $username . "\") AND password = \"" . $password . "\"";

        if (($data = $db->query($query)->fetch_assoc())) {
            $id = $data["id"];
            $dbName = $data["nome"];
            $dbUsername = $data["username"];
            $dbPassword = $data["password"];

            $privateKey = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "chaliwhat/source/server/rsa_keys/private_key.txt");
            $issuer_claim = "chaliwhat";
            $issuedAt_claim = time();
            $notBefore_claim = $issuedAt_claim;
            $expire_claim = $issuedAt_claim + 86400 / 4;  // 6 ore

            $token = array(
                "iss" => $issuer_claim,
                "iat" => $issuedAt_claim,
                "nbf" => $notBefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "id" => $id,
                    "username" => $dbUsername,
                    "name" => $dbName
                )
            );

            $jwt = JWT::encode($token, $privateKey, "HS256");   // creates the JWT
            http_response_code(200);
            setcookie("x-chaliwhat-token", $jwt, $expire_claim, "/chaliwhat");   // il "/chaliwhat" utilizza il cookie per tutte le risorse in quella cartella
        } else {
            http_response_code(400);
            echo json_encode(array("error" => "Invalid credentials"));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array("error" => $e->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("error" => "Enter all credentials"));
}
