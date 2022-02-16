function getJwt(cookies) {
    const cookiesArray = document.cookie.split(";");
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

async function isLogged() {
    let token = getJwt(document.cookie);

    if (token != null) {
        let res = await fetch("http://localhost/chaliwhat/source/server/jwt-controller/jwt-controller.php");

        if (res.status == 200) {
            return true;
        }
        else if (res.status == 401) {
            return false;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function capitalLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}