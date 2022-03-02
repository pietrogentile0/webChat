<?php
require $_SERVER['DOCUMENT_ROOT'] . "chaliwhat/source/server/jwt-manager/jwt-controller.php";
require $_SERVER['DOCUMENT_ROOT'] . "chaliwhat/source/server/databaseService/DatabaseService.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "chaliwhat/source/server/jwt-manager/jwt-getInfo.php"; // altimenti lo prende 2 volte

if (!isLogged()) {
    redirectToLogin();
}

/** Fetches all conversations of an user and sends him them */
function uploadConversations()
{
    $userId = getUserIdFromJwt(getJwt());

    $dbService = new DatabaseService("localhost", "root", "", "chaliwhat");
    $db = $dbService->getConnection();

    /*
    COALESCE is used to get the name of the other user if the chat isn't a group (in this case c.nome would be null)
    IF is used to obtain also other user's username if the chat isn't a group (in this case c.nome would be null)
    */
    $getConversations = "
            SELECT c.id, COALESCE(c.nome, u.nome) AS nome, IF(ISNULL(c.nome), u.username, null) AS username
            FROM utenti AS u,
                partecipanti AS p,
                (SELECT c.* FROM partecipanti AS p, chat as c WHERE p.idChat = c.id AND p.idUtente = $userId) AS c -- this is to get all conversations in which the user is a partecipant 
            WHERE u.id = p.idUtente
                AND p.idChat = c.id
                AND u.id <> $userId
            GROUP BY c.id
        ";

    if (($conversations_rs = $db->query($getConversations))) {
        $conversations = [];

        while (($temp = $conversations_rs->fetch_assoc())) {
            array_push($conversations, $temp);
        }

        echo json_encode($conversations);
    }

    $dbService->closeConnection();
}

uploadConversations();
