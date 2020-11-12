<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Src\controller\NewsController;
use Src\controller\UserController;
use Src\router\Request;
use Src\router\Response;
use Src\router\Router;
use Src\utils\JwtUtil;

$dotenv = new DotEnv(__DIR__);
$dotenv->load();

// $dbConnection = (new DatabaseCon())->getConnection();

/**
 * Routes part
 * to-do:
 * - refactoring moving this logic to another file
 */
Router::get('/', function () {
    echo 'Hello World';
});

Router::get('/users/headers', function (Request $req, Response $res) {
    JwtUtil::validateToken($req::getHeaders());
});

Router::post('/users/login', function (Request $req, Response $res) {
    UserController::logIn($req, $res);
});

Router::post('/users/register', function (Request $req, Response $res) {
    UserController::registerUser($req, $res);
});

//news

Router::get('/news', function (Request $req, Response $res) {
    NewsController::getNews($req, $res);
});

Router::get('/news/([0-9]*)', function (Request $req, Response $res) {
    NewsController::newDetail($req, $res);
});

Router::post('/news', function (Request $req, Response $res) {
    NewsController::addNews($req, $res);
});

// Router::get('/post/([0-9]*)', function (Request $req, Response $res) {
//     $res->toJSON([
//         'post' => ['id' => $req->params[0]],
//         'status' => 'ok',
//     ]);
// });
