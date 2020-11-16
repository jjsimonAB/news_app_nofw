<?php

class NewsTestCest
{
    public function RetrieveAllNewsViaAPI(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsInVzZXIiOnsiaWQiOiIxIiwidXNlcl9uYW1lIjoiamVmZmkifSwiaWF0IjoxNjA1MzA1NzUxfQ.71WUCmFy0RoIFv8zryFMLs_zuSTp0-1VQdbXvnUIq-s');
        $I->sendGet('news');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'success',
        ]);
    }

    public function AddNewsViaAPI(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsInVzZXIiOnsiaWQiOiIxIiwidXNlcl9uYW1lIjoiamVmZmkifSwiaWF0IjoxNjA1MzA1NzUxfQ.71WUCmFy0RoIFv8zryFMLs_zuSTp0-1VQdbXvnUIq-s');
        $I->sendPost('news', [
            "title" => "lo perro de lo... pie",
            "content" => "mirenme los caninos de los pies lol",
            "categories" => [2, 3],
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'success',
        ]);
    }

    public function EditNewsViaAPI(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsInVzZXIiOnsiaWQiOiIxIiwidXNlcl9uYW1lIjoiamVmZmkifSwiaWF0IjoxNjA1MzA1NzUxfQ.71WUCmFy0RoIFv8zryFMLs_zuSTp0-1VQdbXvnUIq-s');
        $I->sendPut('news/11', [
            "title" => "YAMILEEEEEEEEEEEEEEEEEEEEEEET",
            "content" => "mirenme los caninos de los pies lol",
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'success',
        ]);
    }

    public function GetNewsDetailViaAPI(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsInVzZXIiOnsiaWQiOiIxIiwidXNlcl9uYW1lIjoiamVmZmkifSwiaWF0IjoxNjA1MzA1NzUxfQ.71WUCmFy0RoIFv8zryFMLs_zuSTp0-1VQdbXvnUIq-s');
        $I->sendGet('news/1');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'success',
        ]);
    }

    public function DeleteNewsViaAPI(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsInVzZXIiOnsiaWQiOiIxIiwidXNlcl9uYW1lIjoiamVmZmkifSwiaWF0IjoxNjA1MzA1NzUxfQ.71WUCmFy0RoIFv8zryFMLs_zuSTp0-1VQdbXvnUIq-s');
        $I->sendDelete('news/11');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'success',
        ]);
    }
}
