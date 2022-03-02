/**Updates current chat to the one in the chat tab
 * 
 * @param {number} chatId 
 */
function setCurrentChatId(chatId) {
    currentChatId = chatId;
    letKnowCurrentChat(currentChatId);
}

/**Builds the container for a message
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

/** Creates and element with a date as text content (used to show when messages' date change)
 * 
 * @param {Date} date to put in the element as text content
 * @returns {Element} with date as tet content
 */
function createNewDateElement(date) {
    const newDate = document.createElement("div");
    newDate.classList.add("date-container");
    newDate.textContent = date.getDate() + "/" + date.getMonth() + "/" + date.getFullYear();
    return newDate;
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

/** Shows all messages of a chat inside the container passed as parameter
 * 
 * @param {Element} chatContainer container of the messages
 * @param {Object} messages contains all message with relative information
 */
function showMessages(chatContainer, messages) {
    for (let i of messages) {
        let tmpDate = fromStringToDate(i.date); // this tmp variable exists beacuse dateCompare() wants Date element
        if (dateCompare(tmpDate, lastDateOfCurrentChat) == 1) { // in this case i.date is bigger than last date
            const dateElement = createNewDateElement(tmpDate);
            chatContainer.prepend(dateElement);
            lastDateOfCurrentChat = tmpDate;
        }

        const message = createMessageContainer(i.id, i.testo, i.date, i.idMittente, i.username_mittente);
        chatContainer.prepend(message); //appends to the beginning
    }
}

/** When a conversation is selected, this function shows it in the chat tab
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

    resetLastDateOfCurrentChat();

    showMessages(chatContainer, messages);
}

/** Sends a new message to the database
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

/**When the "send-message" button is clicked, this function manages the sending of the message to the server
 */
document.querySelector("#send-message").addEventListener("click", async () => {
    if (currentChatId != null) {
        // const chatContainer = document.querySelector("#chat-container");    // this is for not-live chatting
        const message = document.querySelector("#new-message-text").value;
        document.querySelector("#new-message-text").value = "";

        if (message.length > 0) {
            try {
                sendMessageToServer(message, currentChatId);

                /* this code below is for not-live chatting */
                // const messageId = await sendMessageToServer(message, currentChatId); 
                // const messageContainer = createMessageContainer(messageId, message, userData.id);    
                // chatContainer.prepend(messageContainer);     // these are for not-live chatting
            } catch (error) { alert(error); }
        }
    }
});