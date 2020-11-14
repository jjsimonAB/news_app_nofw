<?php

class UserTestCest
{

    public function createUserViaAPI(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('users/register', [
            'user_name' => 'jeffi233',
            'email' => 'jeffiww@doe.com',
            "password" => "123456",
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'data' => 1,
        ]);
    }

    public function loginUserViaAPI(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('users/register', [
            'email' => 'jeffiww@doe.com',
            "password" => "123456",
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        // $I->seeResponseContainsJson([
        //     'data' => 1,
        // ]);
    }
}
