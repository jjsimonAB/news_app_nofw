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
        );

        $jwt = JWT::encode($payload, $key);

        return $jwt;
    }

}
