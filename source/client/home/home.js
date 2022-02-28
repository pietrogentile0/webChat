/** Sets user's name at the bottom of User's icon
 * @param {string} name User's name
 */
function setIconName(name) {
    const usernameLocation = document.querySelector("#username");

    usernameLocation.textContent = capitalLetter(name);
}

setIconName(userData.name);

document.querySelector("#logo").addEventListener("click", () => {
    location.href = "http://localhost/chaliwhat/source/client/home/home.php";
});

document.querySelector("#logout").addEventListener("click", () => {
    // before logging out, I need to let know Node that I'm going to close WebSocket
    // so it can delete my WebSocket from his list of active ones
    ws.send(JSON.stringify({
        function: "remove-this-socket"
    }))

    document.cookie = "x-chaliwhat-token=; expires=Thu, 01 Jan 1970 00:00:00 CET; path=/chaliwhat; domain=localhost";
    location.href = "http://localhost/chaliwhat/source/client/login/login_page.php";
});

