<?php
require $_SERVER['DOCUMENT_ROOT'] . "chaliwhat/source/server/jwt-manager/jwt-controller.php";
require $_SERVER['DOCUMENT_ROOT'] . "chaliwhat/source/server/databaseService/DatabaseService.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "chaliwhat/source/server/jwt-manager/jwt-getInfo.php"; // altimenti lo prende 2 volte

if (!isLogged()) {
    redirectToLogin();
}

/** Send http messages to the side-car server which manages live-chat
 * @param string $uri uri of the side-car server
 * @param object $headers associative arrays containing all headers of the HTTP message
 * @param object $body associative arrays containing all parameters of the HTTP message's body
 */
function makeHttpnotification($uri, $headers, $body)
{
    $uri = $uri . "/new-message";   // add the "functions" that the server has to do

    $ns = curl_init($uri);    // notification service

    curl_setopt($ns, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ns, CURLOPT_POSTFIELDS, json_encode($body));

    $response = curl_exec($ns);
    curl_close($ns);

    return $response;
}

/** Manages the notification of the message to the side-car service that manages the live-chat
 * @param string $serverUri uri of the side-car server
 * @param integer $chatId id of the messages's chat
 * @param integer $messageId id of the message
 * @param string $text text of the message
 * @param string $datetime date and time in which the message was sent (format "yyyy-mm-dd hh-mm-ss")
 * @param integer $senderId (optional) id of the sender (only in case of a group message)
 * @param string $senderUsername (optional) username of the sender (only in case of a group's message, to specify who sent it)
 * @return boolean true if the response is ok, otherwise false
 */
function notifyToClient($serverUri, $chatId, $messageId, $text, $datetime, $senderId = null, $senderUsername = null)
{
    $headers = array(
        "Content-Type: application/json",
    );

    $body = array(
        "chatId" => $chatId,
        "messageId" => $messageId,
        "text" => $text,
        "senderId" => $senderId,
        "senderUsername" => $senderUsername,
        "datetime" => $datetime
    );

    $response = makeHttpNotification($serverUri, $headers, $body);

    if ($response) {
        return true;
    } else {
        return false;
    }
}

/** Menages the insertion of the new message in the messages table on the server and notify it to the side-car server that manages the live-chat */
function newMessage()
{
    $params = json_decode(file_get_contents("php://input"), true);

    if (isset($params["message"]) && isset($params["idChat"])) {
        $idChat = $params["idChat"];
        $message = $params["message"];
        $idSender = getUserIdFromJwt(getJwt());

        try {
            $dbService = new DatabaseService("localhost", "root", "", "chaliwhat");
            $db = $dbService->getConnection();

            $newMessage = "INSERT INTO messaggi(idMittente, idChat, testo) VALUES ($idSender, $idChat, \"" . $message . "\")";
            $db->query($newMessage);

            $getMessageId = "SELECT LAST_INSERT_ID() AS id, m.date FROM messaggi AS m WHERE m.id = LAST_INSERT_ID()";
            $rs = $db->query($getMessageId)->fetch_assoc();

            $newMessageId = $rs["id"];
            $datetime = $rs["date"];

            http_response_code(200);
            echo json_encode(array("messageId" => $newMessageId));

            notifyToClient("http://localhost:3000", $idChat, $newMessageId, $message, $datetime, $idSender);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(array("error" => $e->getMessage()));
        }

        $dbService->closeConnection();
    } else {
        http_response_code(400);
    }
}

newMessage();
