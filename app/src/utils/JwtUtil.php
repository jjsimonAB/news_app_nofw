<?php

namespace Src\utils;

use \Firebase\JWT\JWT;

class JwtUtil
{
    public static function generateJwt($body = [])
    {
        $key = getenv('JWT_KEY');
        $payload = array(
            "iss" => "http://example.org",
            "user" => $body,
            "iat" => time(),
        );

        $jwt = JWT::encode($payload, $key);

        return $jwt;
    }

    public static function validateToken($token)
    {
        if (isset($token['Authorization'])) {
            $key = getenv('JWT_KEY');
            $jwtToken = explode(" ", $token["Authorization"]);

            try {
                $decodedToken = JWT::decode($jwtToken[1], $key, array('HS256'));
                return $decodedToken;
            } catch (Exceptino $e) {
                return $e;
            }
        } else {
            return false;
        }
    }

}
