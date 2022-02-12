<?php
    require("./../login-token/DatabaseService.php");
    $params = json_decode(file_get_contents("php://input"), true);

    if(((isset($params["username"]) && $params["username"] != "") || (isset($params["email"]) && $params["email"] != "")) && (isset($params["password"]) && $params["password"] != "")){
        $username = isset($params["username"]) ? $params["username"] : $params["email"];
        $password = hash("sha256", $params["password"]);

        $dbService = new DatabaseService("localhost", "root", "", "chaliwhat");
        $db = $dbService->getConnection();
        try{
            $query = "SELECT id FROM utenti WHERE (username = '$username' OR email = '$username') AND password = '$password'";
            if($db->query($query)->num_rows === 1){
                $cookieName = "logged";
                $cookieValue = "true";
                $maxDate = time() + 86400/2; // 86400 = 1 day

                setcookie($cookieName, $cookieValue, $maxDate);
                http_response_code(200);
            }
            else{
                $cookieName = "logged";
                $cookieValue = "false";
                setcookie($cookieName, $cookieValue);

                http_response_code(404);
                echo(json_encode(array("error" => "Invalid credentials!")));
            }
        } catch(Exception $e){
            echo($e);
        }
    }
?>