document.querySelector("#logo").addEventListener("click", () => {
    location.href = "http://localhost/chaliwhat/source/client/login/login_page.php";
});

document.querySelector("#signup-button").addEventListener("click", async () => {
    const username = document.querySelector("#username").value;
    const password = document.querySelector("#password").value;
    const repeatedPassword = document.querySelector("#repeated-password").value;

    const name = document.querySelector("#name").value;
    const surname = document.querySelector("#surname").value;
    const email = document.querySelector("#email").value;

    if (username.length > 0 && password.length > 0 && name.length > 0) {
        if (password == repeatedPassword) {
            const response = await fetch("http://localhost/chaliwhat/source/server/signup/signup.php", {
                method: "post",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({
                    username: username,
                    password: password,
                    name: name,
                    surname: surname,
                    email: email
                })
            });

            if (response.status == 200) {
                location.href = "http://localhost/chaliwhat/source/client/login/login.js";
            }
            else if (response.status == 409) {
                alert("Username or email already exist in our server!");
            }
            else {
                console.log(await response.json());
            }
        }
        else {
            alert("Passwords don't match!");
        }
    }
    else {
        alert("Fill at least username, password and name, please!");
    }
});