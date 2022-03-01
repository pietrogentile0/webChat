<?php
require $_SERVER['DOCUMENT_ROOT'] . "chaliwhat/source/server/jwt-manager/jwt-controller.php";
require $_SERVER['DOCUMENT_ROOT'] . "chaliwhat/source/server/databaseService/DatabaseService.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "chaliwhat/source/server/jwt-manager/jwt-getInfo.php"; // altimenti lo prende 2 volte

if (!isLogged()) {
    redirectToLogin();
}

$userId = getUserIdFromJwt(getJwt());

$dbService = new DatabaseService("localhost", "root", "", "chaliwhat");
$db = $dbService->getConnection();

$getConversations = "
        SELECT c.id, COALESCE(c.nome, u.nome) AS nome, IF(ISNULL(c.nome), u.username, c.nome) AS username
        FROM utenti AS u,
            partecipanti AS p,
            (SELECT c.* FROM partecipanti AS p, chat as c WHERE p.idChat = c.id AND p.idUtente = $userId) AS c
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
