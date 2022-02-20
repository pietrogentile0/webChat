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
</head>

<body>
    <nav id="navbar" class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" id="brand" href="http://localhost/chaliwhat/source/client/home/home.php">
                <img src="http://localhost/chaliwhat/source/client/home/chat.png" alt="Logo" width="60"
                    class="d-inline-block mr-2">
                <span id="logo-name">ChaLiWhat</span>
            </a>
            <div class="m-1">
                <img src="http://localhost/chaliwhat/source/client/home/user_icon.png" alt="User icon" width="40" class="d-inline-block">
                <div id="username"></div>
            </div>
        </div>
    </nav>
    <div id="main-frame">
        <div id="conversations-tab" class="tab">
            <div class="title">Conversations</div>
            <div id="conversations-container"></div>
        </div>
        <div id="chat-tab" class="tab">
            <div class="title">Chat</div>
            <div id="chat-container">
                <div class="message">
                    <div class="sender">Mario</div>
                    <div class="text-content">Ciao questo è un nuovo messaggio</div>
                </div>
            </div>
            <div class="new-message-form">
                <span style="width: 100%; margin-right: 1%;"><input type="text" id="message" class="form-control" placeholder="Write new message..."></span>
                <span><input type="button" id="send-message" class="btn" value="Send"></span>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="http://localhost/chaliwhat/source/client/utilities.js"></script>
    <script src="http://localhost/chaliwhat/source/client/home/home.js"></script>
    <script src="http://localhost/chaliwhat/source/client/home/conversation.js"></script>
    <script src="http://localhost/chaliwhat/source/client/home/chat.js"></script>
</body>

</html>