<?php
    require("./../login-token/DatabaseService.php");
    require "./../../jws/vendor/autoload.php";
    use \Firebase\JWT\JWT;

    $params = json_decode(file_get_contents("php://input"), true);

    header("Content-type: application/json");

    if(isset($params["username"]) && $params["username"] != "" && (isset($params["password"]) && $params["password"] != "")){
        $username = $params["username"];
        $password = hash("sha256", $params["password"]);

        $dbService = new DatabaseService("localhost", "root", "", "chaliwhat");
        $db = $dbService->getConnection();
        try{
            $query = "SELECT id, nome, username, password FROM utenti WHERE (username = '$username' OR email = '$username') AND password = '$password'";

            if(($data = $db->query($query)->fetch_assoc())){
                $id = $data["id"];
                $dbName = $data["nome"];
                $dbUsername = $data["username"];
                $dbPassword = $data["password"];

                if(hash("sha256", $password)){
                    $privateKey = file_get_contents("./../../rsa_keys/private_key.txt");
                    $issuer_claim = "chaliwhat";
                    $issuedAt_claim = time();
                    $notBefore_claim = $issuedAt_claim;
                    $expire_claim = $issuedAt_claim + 86400/4;  // 6 ore
    
                    $token = array(
                        "iss" => $issuer_claim,
                        "iat" => $issuedAt_claim,
                        "nbf" => $notBefore_claim,
                        "exp" => $expire_claim,
                        "data" => array(
                            "id" => $id,
                            "username"=> $dbUsername,
                            "name" => $dbName
                        )
                    );
    
                    http_response_code(200);
                    $jwt = JWT::encode($token, $privateKey, "HS256");
                    setcookie("token", $jwt, $expire_claim, "/chaliwhat");   // il "/chaliwhat" utilizza il cookie per tutte le risorse in quella cartella
                }
            } else {
                http_response_code(400);
                echo json_encode(array("error"=>"Invalid credentials"));
            }
        } catch(Exception $e){
            http_response_code(500);
            echo json_encode(array("error"=>$e->getMessage()));
        }
    } else{
        http_response_code(400);
        echo json_encode(array("error"=>"Enter all credentials"));
    }
?>