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

if (isLogged()) {
    location.href = "http://localhost/chaliwhat/source/client/home/home.html";
} else {
    location.href = "http://localhost/chaliwhat/source/client/login/login.html";
}