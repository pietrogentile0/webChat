<?php
    require $_SERVER['DOCUMENT_ROOT']."chaliwhat/source/server/jwt-manager/jwt-controller.php";
    require $_SERVER['DOCUMENT_ROOT']."chaliwhat/source/server/login/login-token/DatabaseService.php";
    require_once $_SERVER['DOCUMENT_ROOT']."chaliwhat/source/server/jwt-manager/jwt-getInfo.php"; // altimenti lo prende 2 volte

    if(!isLogged()){
        redirectToLogin();
    }

    function getInfoFromUsername($db, $username){
        $query = "SELECT id, nome FROM utenti WHERE username = '$username'";
        return ($info = $db->query($query)->fetch_assoc()) ? $info : false;
    }

    function createNewConversation($db, $name = null){
        if($name == null){
            $queryCreateChat = "INSERT INTO chat(nome) VALUES (null)";  // se metto $name = null non funziona correttamente
        }
        else{
            $queryCreateChat = "INSERT INTO chat(nome) VALUES ($name)";
        }
        $db->query($queryCreateChat);

        $maxIdQuery = "SELECT LAST_INSERT_ID() AS id";
        $idChat = $db->query($maxIdQuery)->fetch_assoc()["id"];

        return $idChat;
    }

    function addUserToChat($db, $idChat, $idUser){
        $query = "INSERT INTO partecipanti(idUtente, idChat) VALUES ($idUser, $idChat)";
        $db->query($query);
    }
    
    
    function createChat(){
        $username = json_decode(file_get_contents("php://input"), true)["username"];
    
        try{
            $dbService = new DatabaseService("localhost", "root", "", "chaliwhat");
            $db = $dbService->getConnection();
    
            if(($infoContact = getInfoFromUsername($db, $username))){
                $idContact = $infoContact["id"];
                $myId = getUserIdFromJwt(getJwt());
    
                if($idContact != $myId){
                    $idChat = createNewConversation($db);
                    addUserToChat($db, $idChat, $myId);
                    addUserToChat($db, $idChat, $infoContact["id"]);
                    
                    http_response_code(200);
                    echo json_encode(array("idUser"=>$idContact, "nome"=>$infoContact["nome"]));
                }
                else {
                    http_response_code(400);
                    echo json_encode(array("error"=>"Impossibile creare conversazione con se stessi!"));
                }
            }
            else {
                http_response_code(404);
                echo json_encode(array("error"=>"Utente non esistente"));
            }
        } catch (Exception $e){
            http_response_code(500);
            echo json_encode(array("error"=>$e->getMessage()));
        }
    
        $dbService->closeConnection();        
    }

    createChat();