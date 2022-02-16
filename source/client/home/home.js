// reads the user's name from JWT and shows it with the user icon
function setIconName() {
    const payload = getJwtPayload(getJwt(document.cookie));
    const userData = payload.data;

    const usernameLocation = document.querySelector("#username");
    usernameLocation.textContent = capitalLetter(userData["name"]);
}

setIconName();

async function downloadConversations() {
    const userId = getJwtPayload().id;
    const res = await fetch("http://locahost/chaliwhat/source/server/uploadConversations.php", {
        method: "post",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            "userId": userId
        })
    });
}

function downloadChat() {

}