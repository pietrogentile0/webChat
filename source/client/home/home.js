const userData = getJwtPayload(getJwt(document.cookie)).data;
const currentChat = null;

// reads the user's name from JWT and shows it with the user icon
function setIconName(name) {
    const usernameLocation = document.querySelector("#username");

    usernameLocation.textContent = capitalLetter(name);
}

setIconName(userData.name);