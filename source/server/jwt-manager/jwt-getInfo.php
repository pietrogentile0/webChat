<?php

/** Gives user's JWT's payload
 * @param String $jwt
 * @return String JWT's payload
 */
function getJwtPayload($jwt)
{
    return json_decode(base64_decode(explode(".", $jwt)[1]), true);
}

/** Gives user Id from JWT
 * @param String $jwt
 * @return Integer user's JWT id
 */
function getUserIdFromJwt($jwt)
{
    $payload = getJwtPayload($jwt);
    return $payload["data"]["id"];
}

/** Gives user's JWT 
 * @return String|null JWT is present, otherwise null
 */
function getJwt()
{
    return isset($_COOKIE["x-chaliwhat-token"]) ? $_COOKIE["x-chaliwhat-token"] : null;
}
