<?php
require $_SERVER['DOCUMENT_ROOT']."chaliwhat/source/server/jws/vendor/autoload.php";
require $_SERVER['DOCUMENT_ROOT']."chaliwhat/source/server/jwt-manager/jwt-getInfo.php";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

function isValidJWT($jwt, $privateKey){
    try{
        $decoded = (array) JWT::decode($jwt, new Key($privateKey, "HS256"));
        return true;
    } catch (Exception $e){
        echo json_encode(array("error"=>$e->getMessage()));
        return false;
    }
}

function redirectToLogin(){
    header("Location: http://localhost/chaliwhat/source/client/login/login_page.php");
}

function redirectToHome(){
    header("Location: http://localhost/chaliwhat/source/client/home/home.php");
}

function isLogged(){
    if(($jwt = getJwt())){
        try{
            $privateKey = file_get_contents("F:/scuola/5quinta/server_xampp/chaliwhat/source/server/rsa_keys/private_key.txt");
        
            if(isValidJWT($jwt, $privateKey)){
                return true;
            } else {
                return false;
            }
        }catch(Exception $e){
            echo json_encode(array("error"=>$e->getMessage()));
        }
    } else {
        return false;
    }
}