<?php
require "./../jws/vendor/autoload.php";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

if(isset($_COOKIE["token"])){
    try{
        $privateKey = file_get_contents("./../rsa_keys/private_key.txt");
    
        $jwt = $_COOKIE["token"];
        echo $jwt;
        $decoded = (array) JWT::decode($jwt, new Key($privateKey, "HS256"));

        http_response_code(200);
        echo json_encode(array("message"=>"Authorized"));
    }catch(Exception $e){
        http_response_code(401);
        echo json_encode(array("error"=>$e->getMessage()));
    }
} else {
    http_response_code(401);
    echo json_encode(array("error"=>"No cookie set"));
}