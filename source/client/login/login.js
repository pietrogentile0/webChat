// async function controlIfLogged() {
//     if (await isLogged()) {
//         location.href = "http://localhost/chaliwhat/source/client/home/home.html";
//     }
// }

// // si possonao fare meno controlli?
// controlIfLogged(); // non serve await perchè non ci interessa il risultato

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