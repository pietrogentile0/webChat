<?php
    require "./../jwt-controller/jwt-controller.php";
    require("./../login/login-token/DatabaseService.php");

    if(!isLogged()){
        redirectToLogin();
    }

    $params = json_decode(file_get_contents("php://input"), true);
    if(isset($params["userId"])){
        $userId = $params["userId"];
        
        $dbService = new DatabaseService("localhost", "root", "", "chaliwhat");
        $db = $dbService->getConnection();

        $getConversations = "
            SELECT c.id, COALESCE(c.nome, u.nome) AS nome
            FROM utenti AS u,
                partecipanti AS p,
                (SELECT c.* FROM partecipanti AS p, chat as c WHERE p.idChat = c.id AND p.idUtente = 1) AS c	-- trova tutte le chat di un utente
            WHERE u.id = p.idUtente
                AND p.idChat = c.id
                AND u.id <> 1
            GROUP BY c.id
        ";
        
        if(($conversations_rs = $db->query($getConversations))){
            $conversations = [];

            while(($temp = $conversations_rs->fetch_assoc())){
                array_push($conversations, $temp);
            }
            
            echo json_encode($conversations);
        }

        $dbService->closeConnection();
    }