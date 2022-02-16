<?php
    require "./../../server/jwt-controller/jwt-controller.php";

    if(!isLogged()){
        redirectToLogin();
    }
?>

<!DOCTYPE html>

<head>
    <title>ChaLiWhat</title>
    <link rel="icon" href="http://localhost/chaliwhat/source/client/home/chat.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/chaliwhat/source/client/style.css">
    <style>
        .tab-name-style {
            font-size: x-large;
            font-weight: bold;
            text-decoration: underline;
        }

        #mainFrame{
            padding-bottom: 1.5%;
        }

        .tab {
            border-radius: 1%;
            height: 100%;
        }
    </style>
</head>

<body>
    <nav id="navbar" class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" id="brand" href="http://localhost/chaliwhat/source/client/home/home.php">
                <img src="http://localhost/chaliwhat/source/client/home/chat.png" alt="Logo" width="60"
                    class="d-inline-block mr-2">
                <span id="logo-name">ChaLiWhat</span>
            </a>
            <div class="m-2">
                <img src="http://localhost/chaliwhat/source/client/home/user_icon.png" alt="User icon" width="40"
                    class="d-inline-block">
                <div id="username"></div>
            </div>
        </div>
    </nav>

    <div class="container-fluid h-100">
        <div class="row gx-2 h-100" id="mainFrame">
            <!--tab della conversazione-->
            <div class="col-4">
                <div id="conversations" class="container tab">
                    <!-- riga con titolo della conversazione -->
                    <div class="row tab-name-style">
                        <!-- titolo della conversazione -->
                        <div class="col">
                            Conversations
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Robi
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Pietro
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Michele
                        </div>
                    </div>
                </div>
            </div>

            <!--tab della chat-->
            <div class="col-8">
                <div id="chat" class="container tab">
                    <!-- riga con titolo della chat -->
                    <div class="row tab-name-style">
                        <!-- titolo della chat -->
                        <div class="col">
                            Chat
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            ciao sono pietro
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="http://localhost/chaliwhat/source/client/utilities.js"></script>
    <script src="http://localhost/chaliwhat/source/client/home/home.js"></script>
</body>

</html>