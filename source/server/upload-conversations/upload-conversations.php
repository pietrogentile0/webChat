<?php
    require "./../jwt-controller/jwt-controller.php";
    require("./../login/login-token/DatabaseService.php");

    if(!isLogged()){
        redirectToLogin();
    }

    $params = JSON.decode(file_get_contents("php://input"));
    if(isset($params["userId"])){
        $userId = $params["userId"];
        
        $dbService = new DatabaseService("localhost", "root", "", "chaliwhat");
        $db->getConnection();

        $query = "";
    }

