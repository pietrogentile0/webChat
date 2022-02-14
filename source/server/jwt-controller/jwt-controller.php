<?php
require "./../jws/vendor/autoload.php";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

if(isset($_COOKIE["token"])){
    try{
        $privateKey = file_get_contents("./../rsa_keys/private_key.txt");
    
        $jwt = $_COOKIE["token"];
        $decoded = (array) JWT::decode($jwt, new Key($privateKey, "HS256"));

        if($decoded){
            
        }
    }catch(Exception $e){
        echo json_encode(array("error"=>$e->getMessage()));
    }
}