<?php
require $_SERVER["DOCUMENT_ROOT"] . "chaliwhat/source/server/jwt-manager/jwt-controller.php";
require $_SERVER["DOCUMENT_ROOT"] . "chaliwhat/source/server/databaseService/DatabaseService.php";

if (!isLogged()) {
    redirectToLogin();
}

/** Fetches all messages of a specified chat and sends it as a response to the client */
function uploadChat()
{
    $params = json_decode(file_get_contents("php://input"), true);
    if (isset($params["chatId"])) {
        $chatId = $params["chatId"];

        $dbService = new DatabaseService("localhost", "root", "", "chaliwhat");
        $db = $dbService->getConnection();

        /*
        if the chat name is set to null, so that chat is a conversation between only two user
        and server sends to the client the name of the other user instead of null.
        */
        $queryGetMessages = "
                SELECT m.id, m.idMittente, m.testo, m.date, IF(ISNULL(c.nome), null, username) AS username_mittente
                FROM messaggi AS m, utenti AS u, chat AS c
                WHERE u.id = m.idMittente
                    AND m.idChat = c.id
                    AND idChat = $chatId
                ORDER BY m.date
            ";

        $messages_rs = $db->query($queryGetMessages);

        $messagesToUpload = [];
        while (($message = $messages_rs->fetch_assoc())) {
            array_push($messagesToUpload, $message);
        }

        echo json_encode($messagesToUpload);

        $dbService->closeConnection();
    } else {
        echo json_encode(array("error" => "id not filled"));
    }
}

uploadChat();
