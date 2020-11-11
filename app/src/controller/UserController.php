<?php

namespace Src\controller;

use Src\model\UserModel;
use Src\router\Request;
use Src\router\Response;
use Src\utils\JwtUtil;

class UserController
{
    /**
     * Moving this into a static way
     */
    // private Request $request;
    // private Response $response;

    // public function __construct(Request $request, Response $response)
    // {
    //     $this->request = $request;
    //     $this->response = $response;
    // }

    public static function logIn(Request $req, Response $res)
    {
        $body = $req->getJson();
        $model = new UserModel();
        $user = $model->getUserByEmail($body->email);

        if (hash_equals(hash('sha1', $body->password), $user[0]['password'])) {
            $jwtToken = JwtUtil::generateJwt(array(
                "id" => $user[0]['id'],
                "user_name" => $user[0]['user_name'],
            ));

            $res->toJSON([
                'jwt' => $jwtToken,
            ]);
        } else {
            $res->toJSON([
                'error' => "user not found",
            ]);
        }
    }

    public static function registerUser(Request $req, Response $res)
    {
        $model = new UserModel();
        $res->toJSON([
            'data' => $model->registerUser($req->getJson()),
        ]);
    }

}
