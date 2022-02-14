function isLogged() {
    let cookies = document.cookie.split(";");
    for (let c = 0; c < cookies.length; c++) {
        let cookie = cookies[c].split("=");
        if (cookie[0] === "token") {
            return true;
        }
    }
    return false;
}