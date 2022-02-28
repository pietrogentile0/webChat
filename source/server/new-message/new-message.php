<?php
    require $_SERVER['DOCUMENT_ROOT']."chaliwhat/source/server/jwt-manager/jwt-controller.php";
    require $_SERVER['DOCUMENT_ROOT']."chaliwhat/source/server/login/login-token/DatabaseService.php";
    require_once $_SERVER['DOCUMENT_ROOT']."chaliwhat/source/server/jwt-manager/jwt-getInfo.php"; // altimenti lo prende 2 volte

    if(!isLogged()){
        redirectToLogin();
    }

    function makeHttpnotification($url, $headers, $body){
        $url = $url."/new-message";

        $ns = curl_init($url);    // notification service

        curl_setopt($ns, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ns, CURLOPT_POSTFIELDS, json_encode($body));
        
        $response = curl_exec($ns);
        curl_close($ns);

        return $response;
    }

    function notifyToClient($serverUrl, $chatId, $messageId, $text, $datetime, $senderId=null, $senderUsername=null){
        $headers = array(
            "Content-Type: application/json",
        );

        $body = array(
            "chatId"=>$chatId,
            "messageId"=>$messageId,
            "text"=>$text,
            "senderId"=>$senderId,
            "senderUsername"=>$senderUsername,
            "datetime"=>$datetime
        );

        $response =  makeHttpNotification($serverUrl, $headers, $body);

        if($response){
            return true;
        }
        else{
            return false;
        }
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
            
            $getMessageId = "SELECT LAST_INSERT_ID() AS id, m.date FROM messaggi AS m WHERE m.id = id";
            $rs = $db->query($getMessageId)->fetch_assoc();
            $newMessageId = $rs["id"];
            $datetime = $rs["date"];

            http_response_code(200);
            echo json_encode(array("messageId"=>$newMessageId));

            notifyToClient("http://localhost:3000", $idChat, $newMessageId, $message, $datetime, $idSender);
        }catch(Exception $e){
            http_response_code(500);
            echo json_encode(array("error"=>$e->getMessage()));
        }

        $dbService->closeConnection();
    }
    else { http_response_code(400); }