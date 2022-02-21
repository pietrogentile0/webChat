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
 * 
 * @returns JWT payload's information in JSON
 */
function getJwtPayload(jwt) {
    return JSON.parse(atob(jwt.split(".")[1]));
}

function getMyUsername() {
    return getJwtPayload(getJwt(document.cookie)).data.username;
}

function capitalLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}