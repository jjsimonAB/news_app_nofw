<?php

require __DIR__ . '/vendor/autoload.php';

use Src\router\Request;
use Src\router\Response;
use Src\router\Router;

Router::get('/', function () {
    echo 'Hello World';
});

Router::get('/post/([0-9]*)', function (Request $req, Response $res) {
    $res->toJSON([
        'post' => ['id' => $req->params[0]],
        'status' => 'ok',
    ]);
});
