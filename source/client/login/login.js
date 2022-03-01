/** when the login button is clicked, this function sends credentials to the server that,
 *  if the login is successfully, sets a cookie storing the JWT.
 *  If this is the case, the user would be redirected to the home page of the chat.
*/
document.querySelector("#login-button").addEventListener("click", async () => {
    let username = document.querySelector("#username").value;
    let password = document.querySelector("#password").value;

    if (username.length > 0 && password.length > 0) {
        let res = await fetch("http://localhost/chaliwhat/source/server/login/login-cookie/login.php", {
            method: "POST",
            body: JSON.stringify({
                "username": username,
                "password": password
            })
        });

        if (res.status == 200) {
            location.href = "http://localhost/chaliwhat/source/client/home/home.php";
        } else {
            let info = await res.json();
            alert(info.error);
        }
    } else {
        alert("Inserisci credenziali");
    }
});

/** If the signup button is clicked, this function redirects to the sign-up page */
document.querySelector("#signup-button").addEventListener("click", async () => {
    location.href = "http://localhost/chaliwhat/source/client/signup/signup_page.php";
});