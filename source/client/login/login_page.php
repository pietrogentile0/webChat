<?php
    require "./../../server/jwt-controller/jwt-controller.php";

    if (isLogged()){
        redirectToHome();
    }
?>

<html>

<head>
    <title>Login</title>
    <link rel="icon" href="http://localhost/chaliwhat/source/client/home/chat.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/chaliwhat/source/client/style.css">

    <style>
        .tab {
            border-radius: 20px;
        }

        .input-text {
            width: 33%;
        }
    </style>
</head>

<body>
    <nav id="navbar" class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="http://localhost/chaliwhat/source/client/home/home.html">
                <img src="http://localhost/chaliwhat/source/client/home/chat.png" alt="Logo" width="60"
                    class="d-inline-block mr-2">
                <span id="logo-name">ChaLiWhat</span>
            </a>
        </div>
    </nav>
    <div class="container mt-3 p-4 tab">
        <div class="flex-column justify-content-center ml-lg-5">
            <h2>Accedi con le tue credenziali</h2>
            <div class="col mb-3">
                <input type="text" id="username" class="form-control input-text" placeholder="username or email">
            </div>
            <div class="col mb-3">
                <input type="password" id="password" class="form-control input-text" placeholder="password">
            </div>
            <div class="col">
                <input type="button" id="login-button" class="btn" value="Log in">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="http://localhost/chaliwhat/source/client/utilities.js"></script>
    <script src="http://localhost/chaliwhat/source/client/login/login.js"></script>
</body>

</html>