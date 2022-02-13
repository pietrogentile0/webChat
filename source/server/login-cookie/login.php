<?php
    require("./../login-token/DatabaseService.php");
    require "./../jws/vendor/autoload.php";
    use \Firebase\JWT\JWT;

    $params = json_decode(file_get_contents("php://input"), true);

    if(isset($params["username"]) && $params["username"] != "" && (isset($params["password"]) && $params["password"] != "")){
        $username = $params["username"];
        $password = hash("sha256", $params["password"]);

        $dbService = new DatabaseService("localhost", "root", "", "chaliwhat");
        $db = $dbService->getConnection();
        try{
            $query = "SELECT id, username, password FROM utenti WHERE (username = '$username' OR email = '$username') AND password = '$password'";

            if(($data = $db->query($query)->fetch_assoc())){
                $id = $data["id"];
                $dbUsername = $data["username"];
                $dbPassword = $data["password"];

                if(hash("sha256", $password)){
                    $privateKey = file_get_contents("./../rsa_keys/private_key.txt");
                    $issuer_claim = "chaliwhat";
                    $issuedAt_claim = time();
                    $notBefore_claim = $issuedAt_claim;
                    $expire_claim = $issuedAt_claim + 86400/4;  // 4 ore
    
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
                    $jwt = JWT::encode($token, $privateKey, "HS256");
                    setcookie("token", $jwt, $expire_claim);
                } else {
                    http_response_code(400);
                    echo json_encode(array("error"=>"The username or email is ok, but wrong password"));
                }
            } else {
                http_response_code(400);
                echo json_encode(array("error"=>"Invalid credentials"));
            }

            // if($db->query($query)->num_rows === 1){
            //     $cookieName = "logged";
            //     $cookieValue = "true";
            //     $maxDate = time() + 86400/2; // 86400 = 1 day

            //     setcookie($cookieName, $cookieValue, $maxDate);
            //     http_response_code(200);
            // }
            // else{
            //     $cookieName = "logged";
            //     $cookieValue = "false";
            //     setcookie($cookieName, $cookieValue);
            
            //     http_response_code(400);
            //     echo(json_encode(array("error" => "Invalid credentials!")));
            // }
        } catch(Exception $e){
            echo($e);
        }
    } else{
        http_response_code(400);
        echo json_encode(array("error"=>"Insert all credentials"));
    }
?>