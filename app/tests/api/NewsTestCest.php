<?php

class NewsTestCest
{
    public function RetrieveAllNewsViaAPI(ApiTester $I)
    {
        $I->getJwtToken($I);
        $I->sendGet('news');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'success',
        ]);
    }

    public function AddNewsViaAPI(ApiTester $I)
    {
        $I->getJwtToken($I);
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
        $I->getJwtToken($I);
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
        $I->getJwtToken($I);
        $I->sendGet('news/1');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'success',
        ]);
    }

    public function DeleteNewsViaAPI(ApiTester $I)
    {
        $I->getJwtToken($I);
        $I->sendDelete('news/11');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'success',
        ]);
    }
}
