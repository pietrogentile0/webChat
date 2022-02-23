/** Array of all names of conversations of the current user, to check when creating a new one to avoid conversations duplication 
 * @type string
 */
let currentConversations = [];

/** Stores the data of the user contained in his JWT 
 * @type JavaScript Object
*/
const userData = getJwtPayload(getJwt(document.cookie)).data;

/** Stores the chat's ID that has the focus now, to attach as parameter when sending a new message to the server
 * @type number
 */
let currentChatId = null;

function getJwt(cookies) {  // passo i cookie perchè forse potrò riusare la funzione
    const cookiesArray = cookies.split(";");
    for (let c = 0; c < cookiesArray.length; c++) {
        let cookie = cookiesArray[c].split("=");
        if (cookie[0] === "x-chaliwhat-token") {
            return cookie[1];
        }
    }
    return null;
}

/**
 * @param jwt JWT you want payload
 * @returns JWT payload's information in JSON
 */
function getJwtPayload(jwt) {
    return JSON.parse(atob(jwt.split(".")[1]));
}

function getMyUsername() {
    return userData.username;
}

function getMyId() {
    return userData.id;
}

function capitalLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

/**Removes all childs of element
 * 
 * @param {Element} element 
 */
function clearElement(element) {
    element.textContent = "";     // remove a previous chat
}