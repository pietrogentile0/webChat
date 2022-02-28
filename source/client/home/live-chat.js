const ws = new WebSocket("ws://localhost:3001");

ws.onopen = () => {
    letKnowId(getMyId());
}

ws.addEventListener("message", (message) => {
    const chatContainer = document.querySelector("#chat-container");

    const body = JSON.parse(message.data);
    if (body.function == "new-message") {
        const messageId = body.messageId;
        const text = body.text;
        const datetime = body.datetime;
        const senderId = body.senderId;
        const senderUsername = body.senderUsername;

        const messageContainer = createMessageContainer(messageId, text, datetime, senderId, senderUsername);
        chatContainer.prepend(messageContainer);
    }
});

function letKnowId(userId) {
    ws.send(JSON.stringify({
        function: "update-id",
        userId: userId
    }));
}

function letKnowCurrentChat(chatId) {
    ws.send(JSON.stringify({
        function: "update-current-chat",
        currentChat: currentChatId
    }));
}