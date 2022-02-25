<?php
    require $_SERVER['DOCUMENT_ROOT']."chaliwhat/source/server/jwt-manager/jwt-controller.php";
    require $_SERVER['DOCUMENT_ROOT']."chaliwhat/source/server/login/login-token/DatabaseService.php";
    require_once $_SERVER['DOCUMENT_ROOT']."chaliwhat/source/server/jwt-manager/jwt-getInfo.php"; // altimenti lo prende 2 volte

    if(!isLogged()){
        redirectToLogin();
    }

    $params = json_decode(file_get_contents("php://input"), true);
    
    if(isset($params["message"]) && isset($params["idChat"])){
        $idChat = $params["idChat"];
        $message = $params["message"];
        $idSender = getUserIdFromJwt(getJwt());

        try{
            $dbService = new DatabaseService("localhost", "root", "", "chaliwhat");
            $db = $dbService->getConnection();

            $newMessage = "INSERT INTO messaggi(idMittente, idChat, testo) VALUES ($idSender, $idChat, \"".$message."\")";
            $db->query($newMessage);
            
            $getMessageId = "SELECT LAST_INSERT_ID() AS id";
            $newMessageId = $db->query($getMessageId)->fetch_assoc()["id"];

            http_response_code(200);
            echo json_encode(array("chatId"=>$newMessageId));
        }catch(Exception $e){
            http_response_code(500);
            echo json_encode(array("error"=>$e->getMessage()));
        }

        $dbService->closeConnection();
    } 
    else { http_response_code(400); }