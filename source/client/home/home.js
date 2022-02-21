const userData = getJwtPayload(getJwt(document.cookie)).data;
const currentChat = null;

// reads the user's name from JWT and shows it with the user icon
function setIconName(name) {
    const usernameLocation = document.querySelector("#username");

    usernameLocation.textContent = capitalLetter(name);
}

setIconName(userData.name);

document.querySelector("#logo").addEventListener("click", () => {
    location.href = "http://localhost/chaliwhat/source/client/home/home.php";
});

document.querySelector("#logout").addEventListener("click", () => {
    console.log(document.cookie);
    document.cookie = "x-chaliwhat-token=; expires=Thu, 01 Jan 1970 00:00:00 CET; path=/chaliwhat; domain=localhost";
    location.href = "http://localhost/chaliwhat/source/client/login/login_page.php";
});

