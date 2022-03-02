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

/**  this variables stores the last day of the inserted messages up to now, in the current chat;
we need it to show the user when the date of messages changes */
let lastDateOfCurrentChat = fromStringToDate("0000-00-00 00:00:00");

/** Resets the last date of the current chat, useful when the user choose another chat and the date of the massage has to restart from the minimum value */
function resetLastDateOfCurrentChat() {
    lastDateOfCurrentChat = fromStringToDate("0000-00-00 00:00:00");
}

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

/** Compares only days, months and years ignoring time
 * @param {Date} date1 first date to compare
 * @param {Date} date2 second date to compare
 * @returns 1 if date1 > date2, 2 if date2 > date1, 0 if equals
 */
function dateCompare(date1, date2) {
    if (date1.getYear() > date2.getYear()) {
        return 1;
    } else {
        if (date1.getYear() < date2.getYear()) {
            return 2;
        } else {    // years are equals
            if (date1.getMonth() > date2.getMonth()) {
                return 1;
            } else {
                if (date1.getMonth() < date2.getMonth()) {
                    return 2;
                } else {    //months are equals
                    if (date1.getDate() > date2.getDate()) {
                        return 1;
                    } else {
                        if (date1.getDate() < date2.getDate()) {
                            return 2;
                        } else {
                            return 0;   // the dates are equals
                        }
                    }
                }
            }
        }
    }
}

/**Removes all childs of element
 * 
 * @param {Element} element 
 */
function clearElement(element) {
    element.textContent = "";     // remove a previous chat
}