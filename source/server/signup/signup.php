<?php
require $_SERVER["DOCUMENT_ROOT"] . "chaliwhat/source/server/databaseService/DatabaseService.php";

/** This function manages the creation of a new user on the database */
function signup()
{
    $credentials = json_decode(file_get_contents("php://input"), true);

    if (isset($credentials["username"]) && $credentials["username"] != "" && isset($credentials["password"]) && $credentials["password"] != "") {
        $username = $credentials["username"];
        $password = hash("sha256", $credentials["password"]);
        $name = $credentials["name"];
        $surname = $credentials["surname"];
        $email = $credentials["email"];

        $newUser = "INSERT INTO utenti(username, password, nome, cognome, email) VALUES (\"" . $username . "\", \"" . $password . "\",\"" . $name . "\",\"" . $surname . "\",\"" . $email . "\")";

        try {
            $dbService = new DatabaseService("localhost", "root", "", "chaliwhat");
            $db = $dbService->getConnection();

            $db->query($newUser);

            http_response_code(200);
        } catch (Exception $e) {
            http_response_code(409);
            echo json_encode(array("error" => $e->getMessage()));
        }
    }
}

signup();
