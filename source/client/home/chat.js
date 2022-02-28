/**Updates current chat (the one to show in the chat tab)
 * 
 * @param {number} chatId 
 */
function setCurrentChatId(chatId) {
    currentChatId = chatId;
    letKnowCurrentChat(currentChatId);
}

/**Builds the container for a message in the chat
 * 
 * @param {number} messageId to show
 * @param {string} text of the message
 * @param {String} datetime format: "yyyy/mm/dd hh:mm:ss"
 * @param {number} [senderId] ID of the sender
 * @param {string} [sender] name of the sender
 * 
 * @return {Element} message container
 */
function createMessageContainer(messageId, text, datetime, senderId = null, sender = null) {
    const date = fromStringToDate(datetime);

    // create message container
    const message = document.createElement("div");
    message.classList.add("message");
    message.id = messageId;

    // if I sent this message, it must be shown on the right
    if (senderId == getMyId()) {
        message.classList.add("message-from-me");
    }

    // if is a group's message, add sender's username
    if (sender != null) {
        const usernameContainer = document.createElement("div");
        usernameContainer.classList.add("sender");
        usernameContainer.textContent = sender;
        message.append(usernameContainer);
    }

    // add message's text
    const textContainer = document.createElement("div");
    textContainer.classList.add("text-content");
    textContainer.textContent = text;
    message.append(textContainer);

    // add message's time
    const timeContainer = document.createElement("div");
    timeContainer.classList.add("time-container");
    timeContainer.textContent = date.getHours() + ":" + date.getMinutes();
    message.append(timeContainer);

    return message;
}

/** Parses datetime string to Date
 * 
 * @param {String} datetime format: "yyyy/mm/dd hh:mm:ss"
 * @returns {Date} parsed date
 */
function fromStringToDate(datetime) {
    const parts = datetime.split(" ");
    const dateParts = parts[0].split("-");
    const timeParts = parts[1].split(":");

    return new Date(dateParts[0], dateParts[1], dateParts[2], timeParts[0], timeParts[1], timeParts[2]);
}

/** Downloads chat's messages from server
 * 
 * @param {number} chatId ID of the chat you want
 * @returns 
 */
async function downloadChatWith(conversationId) {
    const res = await fetch("http://localhost/chaliwhat/source/server/upload-chat/upload-chat.php", {
        method: "post",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            "chatId": conversationId
        })
    });

    if (res.status == 200) {
        return await res.json();
    }
    else {
        console.log()
    }
}

/**Sets te title of Chat tab
 * 
 * @param {*} name Name of the conversation
 * @param {*} username Username of the conversation
 */
function setChatTitle(name, username) {
    const chatName = document.querySelector("#chat-name");
    chatName.textContent = capitalLetter(name);
    const chatUsername = document.querySelector("#chat-username");
    chatUsername.textContent = username;
}

/** When a conversation is selected, shows it in the right tab (chat tab)
 * @param {Number} conversationId ID of the selected conversation
 * @param {string} name Name of the conversation
 * @param {string} username Username of the person in the conversation (default is null if group)
 */
async function getChatWith(conversationId, name, username = null) {
    const chatContainer = document.querySelector("#chat-container");

    clearElement(chatContainer);
    setChatTitle(name, username);

    setCurrentChatId(conversationId);
    const messages = await downloadChatWith(currentChatId);

    for (let i of messages) {
        const message = createMessageContainer(i.id, i.testo, i.date, i.idMittente, i.username_mittente);
        chatContainer.prepend(message); //appends to the beginning
    }
}

/** Sends a message to the database
 * 
 * @param {string} message 
 * @param {number} idChat 
 */
async function sendMessageToServer(message, idChat) {
    const res = await fetch("http://localhost/chaliwhat/source/server/new-message/new-message.php", {
        method: "post",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            "message": message,
            "idChat": idChat
        })
    });

    const info = await res.json();
    if (res.status == 200) {
        return info.messageId;
    } else {
        throw new Error(info.error);
    }
}

document.querySelector("#send-message").addEventListener("click", async () => {
    if (currentChatId != null) {
        const chatContainer = document.querySelector("#chat-container");
        const message = document.querySelector("#new-message-text").value;
        document.querySelector("#new-message-text").value = "";

        if (message.length > 0) {
            try {
                const messageId = await sendMessageToServer(message, currentChatId);
                // const messageContainer = createMessageContainer(messageId, message, userData.id);
                // chatContainer.prepend(messageContainer);
            } catch (error) { alert(error); }
        }
    }
});