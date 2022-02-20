function createMessageBox(message, senderName) {
    const div = document.createElement("div");
    div.classList.add("message");
    const nameDiv = document.createElement("div");
    // nameDiv.classList;
    const messageDiv = document.createElement("div");
}

async function downloadChatWith(chatId) {
    const res = await fetch("http://localhost/chaliwhat/source/server/upload-chat/upload-chat.php", {
        method: "post",
        headers: {
            "Content-Type": "application/json"
        },
        body: {
            "chatId": chatId
        }
    });

    if (res.status == 200) {
        return await res.json();
    }
    else {
        console.log()
    }
}

async function getChatWith(chatId) {
    let currentChat = chatId;
    alert("searching for chat number " + chatId);
}

async function sendMessage(message, idSender, idChat) {
    const res = await fetch("http://localhost/chaliwhat/source/server/new-message/new-message.php", {
        method: "post",
        headers: {
            "Content-Type": "application/json"
        },
        body: {
            "message": message,
            "idSender": idSender,
            "idChat": idChat
        }
    });

    if (res.status == 200) {
        createMessageBox(message, userData.name);
    } else {
        const info = await res.json();
        alert(info.error);
    }
}

document.querySelector("#send-message").addEventListener("click", () => {
    const message = document.querySelector("#message").value;
    const idSender = userData["id"];

    sendMessage(message, idSender, currentChat);
});

