// async function controlIfLogged() {
//     if (!(await isLogged())) {
//         location.href = "http://localhost/chaliwhat/source/client/login/login.php";
//     }
// }

// controlIfLogged();

// reads the user's name from JWT and shows it with the user icon
function setIconName() {
    const payload = getJwtPayload(getJwt(document.cookie));
    const userData = payload.data;

    const usernameLocation = document.querySelector("#username");
    usernameLocation.textContent = capitalLetter(userData["name"]);
}

setIconName();