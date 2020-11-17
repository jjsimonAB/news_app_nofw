<?php

namespace Src\controller;

use Src\router\Request;
use Src\router\Response;
use Src\service\UserService;
use Src\utils\JwtUtil;

class UserController
{

    /**
     * Logs in an user and response with a valid JWT
     *
     * @param Request $req
     * @param Response $res
     * @return void
     */
    public static function logIn(Request $req, Response $res): void
    {
        $body = $req->getJson();
        $userService = new UserService();
        $user = $userService->getUserByEmail($body->email);

        if (password_verify($body->password, $user[0]['password'])) {
            $jwtToken = JwtUtil::generateJwt(array(
                "id" => $user[0]['id'],
                "user_name" => $user[0]['user_name'],
            ));
            $res->toJSON([
                'data' => $jwtToken,
            ]);
        }

        $res->status(404);
        $res->toJSON([
            'data' => "user not found",
        ]);
    }

    /**
     * Creates a new user in the database
     *
     * @param Request $req
     * @param Response $res
     * @return void
     */
    public static function registerUser(Request $req, Response $res): void
    {
        $userService = new UserService();
        $res->toJSON([
            'data' => $userService->registerUser($req->getJson()),
        ]);
    }
}
