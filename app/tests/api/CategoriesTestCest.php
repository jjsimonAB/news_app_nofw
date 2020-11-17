<?php

class CategoriesTestCest
{
    public function RetrieveAllCategoriesViaAPI(ApiTester $I)
    {
        $I->getJwtToken($I);
        $I->sendGet('categories');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'success',
        ]);
    }

    public function AddCategoryViaAPI(ApiTester $I)
    {
        $I->getJwtToken($I);
        $I->sendPost('categories', [
            "name" => "randommmm",
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'success',
        ]);
    }

    public function EditCategoryViaAPI(ApiTester $I)
    {
        $I->getJwtToken($I);
        $I->sendPut('categories/2', [
            "name" => "YAMILEEEEEEEEEEEEEEEEEEEEEEET",
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'success',
        ]);
    }

    public function DeleteCategoryViaAPI(ApiTester $I)
    {
        $I->getJwtToken($I);
        $I->sendDelete('categories/4');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'success',
        ]);
    }
}
