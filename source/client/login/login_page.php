<?php
    require $_SERVER["DOCUMENT_ROOT"]."chaliwhat/source/server/jwt-manager/jwt-controller.php";

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
            margin: 4% 4% 4% 10%;

            width: 66%;
        }

        .input-text {
            width: 33%;
            margin-bottom: 1%
        }

        #form{
            margin: 3%;
        }
    </style>
</head>

<body>
    <div id="navbar">
        <div id="logo">
            <span><img src="http://localhost/chaliwhat/source/client/home/chat.png" alt="Logo" width="60"></span>
            <span id="logo-name">ChaLiWhat</span>
        </div>
    </div>
    <div class="tab">
        <div id="form">
            <h2>Accedi con le tue credenziali</h2>
            <div>
                <input type="text" id="username" class="form-control input-text" placeholder="username or email">
            </div>
            <div>
                <input type="password" id="password" class="form-control input-text" placeholder="password">
            </div>
            <div>
                <input type="button" id="login-button" class="btn" value="Log in">
            </div>
        </div>
    </div>
    <script src="http://localhost/chaliwhat/source/client/login/login.js"></script>
</body>

</html>