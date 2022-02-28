const express = require("express");
const app = express();
app.use(express.json());
const serverPort = 3000;

const webSocket = require('ws');
const decoder = new TextDecoder();
const webSocketPort = 3001;
const wss = new webSocket.Server({ port: webSocketPort });

let activeSocket = 0;

/** Stores all current websocket with all connected user
 * @type Array of Objects which stores all WebSocket connections
 */
let allOpenedSockets = [];

app.listen(serverPort);

/** This runs when "makeHttpNotification()" is called in "new-message.php".
 * It handles sending of the message to the client, using WebSocket connection 
 * and chat's ID relative to it.
 */
app.post("/new-message", (req, res) => {
    const chatId = req.body.chatId;
    const messageId = req.body.messageId;
    const text = req.body.text;
    const datetime = req.body.datetime;
    const senderId = req.body.senderId;
    const senderUsername = req.body.senderUsername;

    sendMessageToClients(chatId, messageId, text, datetime, senderId, senderUsername);

    res.end();
});

wss.on('connection', ws => {
    activeSocket++;
    console.log(activeSocket + " active socket");
    allOpenedSockets.push(ws);

    ws.on('message', (req) => {
        const body = JSON.parse(decoder.decode(req));

        try {
            if (body.function == "update-id") {
                updateUserIdOfWebsocket(ws, body.userId);
                ws.send(JSON.stringify({ status: 200 }));
            }
            else if (body.function == "update-current-chat") {
                updateCurrentChatIdOfWebsocket(ws, body.currentChat);
                ws.send(JSON.stringify({ status: 200 }));
            }
            else if (body.function == "remove-this-socket") {
                removeSocketFromArray(allOpenedSockets, ws);
            }
            else {
                ws.send(JSON.stringify({ status: 404 }));
            }
        } catch (err) {
            ws.send(JSON.stringify({ status: 500, error: err }));
        }
    });

    ws.on('close', (ws) => {
        activeSocket--;
        console.log(activeSocket + " active socket");
    });
});

/** Returns all WebSockets which have a specified chat's Id active now
 * 
 * @param {Array.WebSocket} allOpenedSockets array with all opened sockets
 * @param {number} currentChatId id by which search WebSockets
 * @returns {Array.WebSocket} array of all WebSocket with specified chat's Id
 */
function getSocketsByChatId(allOpenedSockets, currentChatId) {
    const sockets = [];

    for (let ws of allOpenedSockets) {
        if (ws.currentChatId == currentChatId) {
            sockets.push(ws);
        }
    }
    return sockets;
}

/** Updates (or adds if not inserted yet) user's Id relative to a WebSocket
 * 
 * @param {WebSocket} webSocket
 * @param {number} userId of the user relative to te webSocket
 */
function updateUserIdOfWebsocket(webSocket, userId) {
    webSocket["userId"] = userId;
}

/** Updates (or adds if not inserted yet) current chat's Id relative to a WebSocket
 * 
 * @param {WebSocket} webSocket
 * @param {number} currentChatId of the chat active
*/
function updateCurrentChatIdOfWebsocket(webSocket, currentChatId) {
    webSocket["currentChatId"] = currentChatId;
}

/** Return index of the selected WebSocket (then used to remove it from AllOpenedSocket array when that WebSocket will be closed)
 * 
 * @param {Array.WebSocket} allOpenedSockets 
 * @param {WebSocket} webSocket 
 * @returns {number} index of WebSocket in Array
 */
function getIndexOfWebSocketInArray(allOpenedSockets, webSocket) {
    for (let i = 0; i < allOpenedSockets.length; i++) {
        if (allOpenedSockets[i].userId == webSocket.userId) {
            return i;
        }
    }

    throw new Error("Element not found in the array");
}

/** Removes a WebSocket from Array which stores all active WebSockets
 * 
 * @param {Array.WebSocket} allOpenedSockets from which to remove
 * @param {WebSocket} webSocket to remove
 */
function removeSocketFromArray(allOpenedSockets, webSocket) {
    const socketIndex = getIndexOfWebSocketInArray(allOpenedSockets, webSocket);

    allOpenedSockets.splice(socketIndex, 1);
}

/** Sends the message to all clients which have his chatId as active
 * 
 * @param {*} socketsToLetKnow 
 * @param {*} chatId 
 * @param {*} messageId 
 * @param {*} text 
 * @param {*} senderId 
 * @param {*} senderUsername 
 */
function sendMessageToClients(chatId, messageId, text, datetime, senderId, senderUsername) {
    const socketsToLetKnow = getSocketsByChatId(allOpenedSockets, chatId);

    for (const socket of socketsToLetKnow) {
        socket.send(JSON.stringify({
            function: "new-message",
            chatId: chatId,
            messageId: messageId,
            text: text,
            datetime: datetime,
            senderId: senderId,
            senderUsername: senderUsername
        }));
    }
}