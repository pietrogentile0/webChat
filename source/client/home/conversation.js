/** Adds the conversation username to the array of conversations' names
 * @param {string} username 
 */
function addConversationToConversations(name) {
    currentConversations.push(name);
}

/** Manages the DOM to show the conversation in the conversation tab
 * 
 * @param {number} conversationId 
 * @param {String} nome 
 * @param {String} username 
 * 
 * @returns {Element} formatted div with selected attributes passed as parameters
 */
function createConversationDiv(conversationId, nome, username) {
    const conversationContainer = document.createElement("div");
    conversationContainer.classList.add("conversation");    // to apply css rules
    conversationContainer.id = conversationId;
    // this function, when the conversation will be selected, contacts the server to receive all its messages
    conversationContainer.onclick = () => getChatWith(conversationId, nome, username);

    const nameContainer = document.createElement("span");
    nameContainer.textContent = capitalLetter(nome);
    conversationContainer.append(nameContainer);

    // this is only for user (so not group) purposes
    if (username != null) {
        const usernameContainer = document.createElement("span");
        usernameContainer.classList.add("conversation-username");   // to apply css
        usernameContainer.textContent = username;
        conversationContainer.append(usernameContainer);
    }

    return conversationContainer;
}

/** Manages the showing of the conversation in the conversations tab
 * 
 * @param {number} id of the conversation
 * @param {String} name of the user relative to the conversation
 * @param {String} username of the user relative to the conversation (null if group)
 */
function addConversation(id, name, username = null) {
    const conversationsBox = document.querySelector("#conversations-container");

    const conversationDiv = createConversationDiv(id, name, username);

    if (username != null) { addConversationToConversations(username) }

    conversationsBox.append(conversationDiv);
}

/** Contacts the server to get all the conversation of the current user
 * (it isn't necessary to attach any user information because they are present in the user's JWT, present as cookie)
 * 
 * @returns {JSON} Object with all user's conversations
 */
async function downloadConversations() {
    const res = await fetch("http://localhost/chaliwhat/source/server/upload-conversations/upload-conversations.php", {
        method: "post"
    });

    return await res.json();
}

/** Manages the download of conversations from the server and the showing in the conversation tab
 */
async function getConversations() {
    const data = await downloadConversations();

    for (let i = 0; i < data.length; i++) {
        addConversation(data[i].id, data[i].nome, data[i].username);
    }
}

/** When the button "#search-username" is clicked, this function contacts the server in order to:
 *  1. create a new chat with the selected user
 *  2. link the partecipants to it
 *  3. get information about this new chat
 * 
 *  After that, a new conversation is added to the left tab,
 *  which is clickable to open the conversation and chat with the partecipants.
 */
document.querySelector("#search-username").addEventListener("click", async () => {
    const username = document.querySelector("#new-conversation-username").value;
    document.querySelector("#new-conversation-username").value = "";

    if (username.length > 0) {
        if (username != getMyUsername()) {
            if (!currentConversations.includes(username)) {
                const res = await fetch("http://localhost/chaliwhat/source/server/new-conversation/new-conversation.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        "username": username
                    })
                });

                const data = await res.json();
                if (res.status == 200) {
                    addConversation(data.idChat, data.nome, username);
                    currentConversations.push(username);
                }
                else if (res.status == 404) {
                    alert("Contact not found");
                }
                else if (res.status == 400) {
                    alert(data.error);
                }
                else {
                    console.log(data.error);
                }
            }
            else {
                alert("This conversation already exists");
            }
        }
        else {
            alert("Creating a self-conversation is not possible");
        }
    }
});

getConversations(); // this is executed at beginning, to shows on the conversations tab all already active ones