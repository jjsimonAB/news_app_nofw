<?php

class CategoriesTestCest
{
    public function RetrieveAllCategoriesViaAPI(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsInVzZXIiOnsiaWQiOiIxIiwidXNlcl9uYW1lIjoiamVmZmkifSwiaWF0IjoxNjA1MzA1NzUxfQ.71WUCmFy0RoIFv8zryFMLs_zuSTp0-1VQdbXvnUIq-s');
        $I->sendGet('categories');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'data' => [],
        ]);
    }

    public function AddCategoryViaAPI(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsInVzZXIiOnsiaWQiOiIxIiwidXNlcl9uYW1lIjoiamVmZmkifSwiaWF0IjoxNjA1MzA1NzUxfQ.71WUCmFy0RoIFv8zryFMLs_zuSTp0-1VQdbXvnUIq-s');
        $I->sendPost('categories', [
            "name" => "randommmm",
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'data' => 1,
        ]);
    }

    public function EditCategoryViaAPI(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsInVzZXIiOnsiaWQiOiIxIiwidXNlcl9uYW1lIjoiamVmZmkifSwiaWF0IjoxNjA1MzA1NzUxfQ.71WUCmFy0RoIFv8zryFMLs_zuSTp0-1VQdbXvnUIq-s');
        $I->sendPut('categories/2', [
            "name" => "YAMILEEEEEEEEEEEEEEEEEEEEEEET",
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'data' => 1,
        ]);
    }

    public function DeleteCategoryViaAPI(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsInVzZXIiOnsiaWQiOiIxIiwidXNlcl9uYW1lIjoiamVmZmkifSwiaWF0IjoxNjA1MzA1NzUxfQ.71WUCmFy0RoIFv8zryFMLs_zuSTp0-1VQdbXvnUIq-s');
        $I->sendDelete('categories/4');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        // $I->seeResponseContainsJson([
        //     'data',
        // ]);
    }
}
