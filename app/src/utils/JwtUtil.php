<?php

namespace Src\utils;

use Firebase\JWT\JWT;
use Exception;

class JwtUtil
{

    /**
     * Creates a new valid JWT token
     * 
     * @param array body
     * @return string jwtToken
     */
    public static function generateJwt(array $body = []): string
    {
        $key = getenv('JWT_KEY');
        $payload = array(
            "iss" => getenv("JWT_ISS"),
            "user" => $body,
            "iat" => time(),
        );

        $jwt = JWT::encode($payload, $key);
        return $jwt;
    }

    /**
     * Given a jwt validates it and return if its valid or not
     * 
     * @param string token
     * @return string jwtToken
     */
    public static function validateToken($token): object
    {
        if (isset($token['Authorization'])) {
            $key = getenv('JWT_KEY');
            $jwtToken = explode(" ", $token["Authorization"]);

            try {
                $decodedToken = JWT::decode($jwtToken[1], $key, array('HS256'));
                return $decodedToken;
            } catch (Exception $e) {
                return $e;
            }
        } else {
            return false;
        }
    }
}
