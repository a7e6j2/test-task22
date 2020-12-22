<?php
class ApiCest 
{    
    public function tryApi(ApiTester $I)
    {
        $I->sendGet('/service');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}