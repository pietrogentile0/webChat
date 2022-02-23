/** Adds the conversation to the array of conversations' names
 * @param {string} username 
 */
function addConversationToConversations(name) {
    currentConversations.push(name);
}

function createConversationDiv(conversationId, nome, username) {
    const conversationContainer = document.createElement("div");
    conversationContainer.classList.add("conversation");
    conversationContainer.id = conversationId;
    conversationContainer.onclick = () => getChatWith(conversationId, nome, username);

    const nameContainer = document.createElement("span");
    nameContainer.textContent = capitalLetter(nome);
    conversationContainer.append(nameContainer);

    if (username != null) {
        const usernameContainer = document.createElement("span");
        usernameContainer.classList.add("conversation-username");
        usernameContainer.textContent = username;
        conversationContainer.append(usernameContainer);
    }

    return conversationContainer;
}

function addConversation(id, nome, username) {
    const conversationsBox = document.querySelector("#conversations-container");

    const conversationDiv = createConversationDiv(id, nome, username);

    if (username != null) { addConversationToConversations(username) }

    conversationsBox.append(conversationDiv);
}

async function downloadConversations() {
    const res = await fetch("http://localhost/chaliwhat/source/server/upload-conversations/upload-conversations.php", {
        method: "post"
    });

    return await res.json();
}

async function getConversations() {
    const data = await downloadConversations();

    for (let i = 0; i < data.length; i++) {
        addConversation(data[i].id, data[i].nome, data[i].username);
    }
}

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
                    addConversation(data.idUser, data.nome, username);
                    currentConversations.push(username);
                }
                else if (res.status == 404) {
                    alert("Contatto non trovato");
                }
                else if (res.status == 400) {
                    alert(data.error);
                }
                else {
                    console.log(data.error);
                }
            }
            else {
                alert("Conversazione già esistente");
            }
        }
        else {
            alert("Impossibile creare conversazione con se stessi!");
        }
    }
});


getConversations();