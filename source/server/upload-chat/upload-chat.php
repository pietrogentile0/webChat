<?php
    require $_SERVER["DOCUMENT_ROOT"]."chaliwhat/source/server/jwt-manager/jwt-controller.php";
    require $_SERVER["DOCUMENT_ROOT"]."chaliwhat/source/server/login/login-token/DatabaseService.php";

    if(!isLogged()){
        redirectToLogin();
    }

    $params = json_decode(file_get_contents("php://input"), true);
    if(isset($params["chatId"])){
        $chatId = $params["chatId"];

        $dbService = new DatabaseService("localhost", "root", "", "chaliwhat");
        $db = $dbService->getConnection();

        $queryGetMessages = "
            SELECT m.id, m.idMittente, m.testo, IF(ISNULL(c.nome), null, username) AS username_mittente
            FROM messaggi AS m, utenti AS u, chat AS c
            WHERE u.id = m.idMittente
                AND m.idChat = c.id
                AND idChat = $chatId
            ORDER BY m.date
        ";
        
        $messages_rs = $db->query($queryGetMessages);

        $messagesToUpload = [];
        while(($message = $messages_rs->fetch_assoc())){
            array_push($messagesToUpload, $message);
        }

        echo json_encode($messagesToUpload);

        $dbService->closeConnection();
    } else {
        echo json_encode(array("error"=>"id not filled"));
    }