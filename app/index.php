<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Src\controller\CategoriesController;
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
 * TO-DO:
 * - refactoring moving this logic to another file
 */
Router::get('/', function () {
    echo 'Hello World';
});

Router::post('/users/login', function (Request $req, Response $res) {
    UserController::logIn($req, $res);
});

Router::post('/users/register', function (Request $req, Response $res) {
    UserController::registerUser($req, $res);
});

/**
 * TO-DO
 * -implement some sort of middleware logic
 * -refactor, authorization logic
 */

//news routes
Router::get('/news', function (Request $req, Response $res) {
    $token = JwtUtil::validateToken($req->getHeaders());
    if ($token) {
        $req->setUser($token->user);
        NewsController::getNews($req, $res);
    } else {
        $res->status(401);
        $res->toJSON([
            'error' => "Unauthorized token",
        ]);
    }
});

Router::get('/news/f/(.*)', function (Request $req, Response $res) {
    $token = JwtUtil::validateToken($req->getHeaders());
    if ($token) {
        $req->setUser($token->user);
        NewsController::getNewsFiltred($req, $res);
    } else {
        $res->status(401);
        $res->toJSON([
            'error' => "Unauthorized token",
        ]);
    }
});

Router::get('/news/([0-9]*)', function (Request $req, Response $res) {
    $token = JwtUtil::validateToken($req->getHeaders());
    if ($token) {
        $req->setUser($token->user);
        NewsController::getNewsDetail($req, $res);
    } else {
        $res->status(401);
        $res->toJSON([
            'error' => "Unauthorized token",
        ]);
    }
});

Router::post('/news', function (Request $req, Response $res) {
    $token = JwtUtil::validateToken($req->getHeaders());
    if ($token) {
        $req->setUser($token->user);
        NewsController::addNews($req, $res);
    } else {
        $res->status(401);
        $res->toJSON([
            'error' => "Unauthorized token",
        ]);
    }
});

Router::put('/news/([0-9]*)', function (Request $req, Response $res) {
    $token = JwtUtil::validateToken($req->getHeaders());
    if ($token) {
        $req->setUser($token->user);
        NewsController::editNew($req, $res);
    } else {
        $res->status(401);
        $res->toJSON([
            'error' => "Unauthorized token",
        ]);
    }
});

Router::delete('/news/([0-9]*)', function (Request $req, Response $res) {
    $token = JwtUtil::validateToken($req->getHeaders());
    if ($token) {
        $req->setUser($token->user);
        NewsController::deleteNews($req, $res);
    } else {
        $res->status(401);
        $res->toJSON([
            'error' => "Unauthorized token",
        ]);
    }
});

// Categories routes
Router::get('/categories', function (Request $req, Response $res) {
    $token = JwtUtil::validateToken($req->getHeaders());
    if ($token) {
        $req->setUser($token->user);
        CategoriesController::getCategories($req, $res);
    } else {
        $res->status(401);
        $res->toJSON([
            'error' => "Unauthorized token",
        ]);
    }
});

Router::post('/categories', function (Request $req, Response $res) {
    $token = JwtUtil::validateToken($req->getHeaders());
    if ($token) {
        $req->setUser($token->user);
        CategoriesController::addCategory($req, $res);
    } else {
        $res->status(401);
        $res->toJSON([
            'error' => "Unauthorized token",
        ]);
    }
});

Router::put('/categories/([0-9]*)', function (Request $req, Response $res) {
    $token = JwtUtil::validateToken($req->getHeaders());
    if ($token) {
        $req->setUser($token->user);
        CategoriesController::editCategory($req, $res);
    } else {
        $res->status(401);
        $res->toJSON([
            'error' => "Unauthorized token",
        ]);
    }
});

Router::delete('/categories/([0-9]*)', function (Request $req, Response $res) {
    $token = JwtUtil::validateToken($req->getHeaders());
    if ($token) {
        $req->setUser($token->user);
        CategoriesController::deleteCategory($req, $res);
    } else {
        $res->status(401);
        $res->toJSON([
            'error' => "Unauthorized token",
        ]);
    }
});
