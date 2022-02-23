<?php
    require "./../../server/jwt-manager/jwt-controller.php";

    if(!isLogged()){
        redirectToLogin();
    }
?>
<!DOCTYPE html>

<head>
    <title>ChaLiWhat</title>
    <link rel="icon" href="http://localhost/chaliwhat/source/client/home/chat.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/chaliwhat/source/client/style.css">
</head>

<body>
    <div id="navbar">
        <div id="logo">
            <span><img src="http://localhost/chaliwhat/source/client/home/chat.png" alt="Logo" width="60"></span>
            <span id="logo-name">ChaLiWhat</span>
        </div>
        <div id="user-info">
            <div id="user-logo">
                <div><img src="http://localhost/chaliwhat/source/client/home/user_icon.png" alt="User icon" width="40"></div>
                <div id="username"></div>
            </div>
            <button id="logout" class="btn">Log-out</button>
        </div>
    </div>

    <div id="main-frame">
        <div id="conversations-tab" class="tab">
            <div id="conversation-title">
                <div class="title">Conversations</div>
                <!-- <input type="button" id="new-group" class="btn" value="New Group"> -->
            </div>
            <div class="form" style="margin-bottom: 3%; width: 100%;">
                <input type="text" id="new-conversation-username" class="form-control" placeholder="Search username">
                <input type="button" id="search-username" class="btn" value="Contact">
            </div>
            <div id="conversations-container"></div>
        </div>

        <div id="chat-tab" class="tab">
            <div class="title chat-title">
                <div id="chat-name"></div>
                <div id="chat-username"></div>
            </div>
            <div id="chat-container">
            </div>
            <div class="form">
                <input type="text" id="message" class="form-control" placeholder="Write new message...">
                <input type="button" id="send-message" class="btn" value="Send">
            </div>
        </div>
    </div>

    <script src="http://localhost/chaliwhat/source/client/utilities.js"></script>
    <script src="http://localhost/chaliwhat/source/client/home/home.js"></script>
    <script src="http://localhost/chaliwhat/source/client/home/chat.js"></script>
    <script src="http://localhost/chaliwhat/source/client/home/conversation.js"></script>
    <!-- <script src="http://localhost/chaliwhat/source/client/home/new-group.js"></script> -->
</body>

</html>