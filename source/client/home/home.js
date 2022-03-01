/** Sets user's name below of User's icon (top-right corner)
 * @param {string} name User's name
 */
function setIconName(name) {
    const usernameLocation = document.querySelector("#username");

    usernameLocation.textContent = capitalLetter(name);
}

/** Deletes a cookie
 * 
 * @param {String} name of the cookie
 * @param {String} path of the cookie
 * @param {String} domain of the cookie
 */
function deleteCookie(name, path, domain) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 CET; path=" + path + "; domain=" + domain;
}

setIconName(userData.name);

// this function is perfromed when the logo (top-left corner) is clicked
document.querySelector("#logo").addEventListener("click", () => {
    location.href = "http://localhost/chaliwhat/source/client/home/home.php";
});

// this function is performed when the log-out button is clicked
document.querySelector("#logout").addEventListener("click", () => {
    // before logging out, I need to let know Node server that I'm going to close WebSocket
    // so it can delete my WebSocket from his list of active ones
    ws.send(JSON.stringify({
        function: "remove-this-socket"
    }))

    deleteCookie("x-chaliwhat-token", "/chaliwhat", "localhost");
    location.href = "http://localhost/chaliwhat/source/client/login/login_page.php";
});

