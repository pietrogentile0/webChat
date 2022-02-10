<?php
require "DatabaseService.php";
require "../../jws/vendor/autoload.php";
use \Firebase\JWT\JWT;

$params = json_decode(file_get_contents("php://input"), true);

if((isset($params["email"]) || isset($params["username"])) && isset($params["password"])){
    $username = isset($params["email"]) ? $params["email"] : $params["username"];
    $password = $params["password"];

    try{
        $dbService = new DatabaseService("localhost", "root", "", "webchat");
        $db = $dbService->getConnection();
        
        $query = "SELECT id, username, password FROM Utenti WHERE username = '$username' LIMIT 1";
        $rs = $db->query($query);
        
        if($rs->num_rows > 0){
            $data = $res->fetch_assoc();

            $id = $data["id"];
            $dbUsername = $data["username"];
            $dbPassword = $data["password"];

            if(password_verify($password, $dbPassword)){
                $privateKey = file_get_contents("./rsa_keys/private_key.txt");
                $issuer_claim = "chaliwhat";
                $issuedAt_claim = time();
                $notBefore_claim = $issuedAt_claim;
                $expire_claim = $issuedAt_claim + 60;

                $token = array(
                    "iss" => $issuer_claim,
                    "iat" => $issuedAt_claim,
                    "nbf" => $notBefore_claim,
                    "exp" => $expire_claim,
                    "data" => array(
                        "id" => $id,
                        "username"=> $dbUsername
                    )
                );

                http_response_code(200);
                $jwt = JWT::encode($token, $privateKey);
                echo json_encode(
                    array(
                        "message" => "Successful login",
                        "jwt" => $jwt,  
                        "username" => $username
                    )
                );
            }
        } else {
            http_response_code(401);
            echo json_encode(array("error"=>"Your credentials aren't on our database"));
        }

        $db->close();
    }catch(Exception $e){
        echo(json_encode(array("error"=>"$e")));
    }

}