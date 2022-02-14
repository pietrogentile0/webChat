async function isLogged() {
    let token = null;

    const cookies = document.cookie.split(";");
    for (let c = 0; c < cookies.length; c++) {
        let cookie = cookies[c].split("=");
        if (cookie[0] === "token") {
            token = cookie[1];
            break;
        }
    }

    if (token != null) {
        let res = await fetch("http://localhost/chaliwhat/source/server/jwt-controller/jwt-controller.php");

        // let body = await res.json();

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