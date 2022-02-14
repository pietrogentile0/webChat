async function controlIfLogged() {
    if (!(await isLogged())) {
        location.href = "http://localhost/chaliwhat/source/client/login/login.html";
    }
}

controlIfLogged();