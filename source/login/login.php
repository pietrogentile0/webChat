<?php
require "DatabaseService.php";
require "../../jws/vendor/autoload.php";
use \Firebase\JWT\JWT;

$data = json_decode(file_get_contents("php://input"));

if((isset($data["email"]) || isset($data["username"])) && isset($data["password"])){
    $username = isset($data["email"]) ? $data["email"] : $data["username"];
    $password = $data["password"];

    try{
        $dbService = new DatabaseService("localhost", "root", "", "webchat");
        $db = $dbService->getConnection();
    }catch(Exception $e){
        echo(json_encode(array("error"=>$e)));
    }

    $query = "SELECT id, username, password FROM Utenti WHERE username = '$username' LIMIT 1";
}