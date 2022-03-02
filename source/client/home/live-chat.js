const ws = new WebSocket("ws://localhost:3001");

// when the WebSocket is opened I immediately pass to the server user's id
ws.onopen = () => {
    letKnowId(getMyId());
}

/** When a new message is received from the server, it's added to the chat container to be shown to user */
ws.addEventListener("message", (message) => {
    const chatContainer = document.querySelector("#chat-container");

    const body = JSON.parse(message.data);
    if (body.function == "new-message") {
        const messageId = body.messageId;
        const text = body.text;
        const datetime = body.datetime;
        const senderId = body.senderId;
        const senderUsername = body.senderUsername;

        let tmpDate = fromStringToDate(datetime); // this tmp variable exists because dateCompare() wants Date element as parameter
        if (dateCompare(tmpDate, lastDateOfCurrentChat) == 1) { // in this case i.date is bigger than last date
            const dateElement = createNewDateElement(tmpDate);
            chatContainer.prepend(dateElement);

            lastDateOfCurrentChat = tmpDate;
        }

        const messageContainer = createMessageContainer(messageId, text, datetime, senderId, senderUsername);
        chatContainer.prepend(messageContainer);
    }
});

/** Sends to the server an user's Id, 
 * this is useful to uniquely identify specific WebSockets in the server
 * 
 * @param {number} userId 
 */
function letKnowId(userId) {
    ws.send(JSON.stringify({
        function: "update-id",
        userId: userId
    }));
}

/** Sends to the server the current active chat's id, 
 * so it will send to client only messages relative to it
 * 
 * @param {number} chatId 
 */
function letKnowCurrentChat(chatId) {
    ws.send(JSON.stringify({
        function: "update-current-chat",
        currentChat: chatId
    }));
}