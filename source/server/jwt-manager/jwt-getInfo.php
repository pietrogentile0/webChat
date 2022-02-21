<?php
    function getJwtPayload($jwt){
        return json_decode(base64_decode(explode(".", $jwt)[1]), true);
    }

    function getUserIdFromJwt($jwt){
        $payload = getJwtPayload($jwt);
        return $payload["data"]["id"];
    }

    function getJwt(){
        return isset($_COOKIE["x-chaliwhat-token"]) ? $_COOKIE["x-chaliwhat-token"] : null;
    }