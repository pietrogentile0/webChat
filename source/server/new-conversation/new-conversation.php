<?php
require $_SERVER['DOCUMENT_ROOT'] . "chaliwhat/source/server/jwt-manager/jwt-controller.php";
require $_SERVER['DOCUMENT_ROOT'] . "chaliwhat/source/server/databaseService/DatabaseService.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "chaliwhat/source/server/jwt-manager/jwt-getInfo.php"; // altimenti lo prende 2 volte

if (!isLogged()) {
    redirectToLogin();
}

/** Gives user's Id and Name by his Username
 * @param mysqli_connection $db connection to the database which stores users
 * @param string $username of the user to search
 * @return Object|false object(with id and name) if user is present, otherwise false
 */
function getInfoFromUsername($db, $username)
{
    $query = "SELECT id, nome FROM utenti WHERE username = '$username'";
    return ($info = $db->query($query)->fetch_assoc()) ? $info : false;
}

/** Creates new conversation in the conversation table on the database
 * @param mysqli_connection $db connection to the database
 * @param string $name (optional) name of the new conversation (onlhy if it's a group)
 */
function createNewConversation($db, $name = null)
{
    if ($name == null) {
        $queryCreateChat = "INSERT INTO chat(nome) VALUES (null)";  // se metto $name = null non funziona correttamente
    } else {
        $queryCreateChat = "INSERT INTO chat(nome) VALUES ($name)";
    }
    $db->query($queryCreateChat);

    $maxIdQuery = "SELECT LAST_INSERT_ID() AS id";
    $idChat = $db->query($maxIdQuery)->fetch_assoc()["id"];

    return $idChat;
}

/** Adds user to selected chat
 * @param mysqli_connection $db connection to the database
 * @param Integer $idChat id of the chat you wants to add partecipant
 * @param Integer $idUSer id of the user you wants to the chat
 */
function addUserToChat($db, $idChat, $idUser)
{
    $query = "INSERT INTO partecipanti(idUtente, idChat) VALUES ($idUser, $idChat)";
    $db->query($query);
}

/** Creates a new chat and adds partecipants to it */
function createChat()
{
    $username = json_decode(file_get_contents("php://input"), true)["username"];

    try {
        $dbService = new DatabaseService("localhost", "root", "", "chaliwhat");
        $db = $dbService->getConnection();

        if (($infoContact = getInfoFromUsername($db, $username))) {
            $idContact = $infoContact["id"];
            $myId = getUserIdFromJwt(getJwt());

            // to ensure that an user doesn't start a self-conversation
            if ($idContact != $myId) {
                $idChat = createNewConversation($db);
                addUserToChat($db, $idChat, $myId);
                addUserToChat($db, $idChat, $infoContact["id"]);

                http_response_code(200);
                echo json_encode(array("idUser" => $idContact, "nome" => $infoContact["nome"], "idChat" => $idChat));
            } else {
                http_response_code(400);
                echo json_encode(array("error" => "Creating a self conversation is not allowed"));
            }
        } else {
            http_response_code(404);
            echo json_encode(array("error" => "The selected user doesn't exists"));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array("error" => $e->getMessage()));
    }

    $dbService->closeConnection();
}

createChat();
