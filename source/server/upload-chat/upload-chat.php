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

        $queryGetMessages = "SELECT * FROM Messaggi WHERE idChat = $chatId";
        $messages_rs = $db->query($queryGetMessages);

        while(($message = $messages_rs->fetch_assoc())){
            echo $message;
        }

        $dbService->closeConnection();
    } else {
        echo json_encode(array("error"=>"id not filled"));
    }