<?php
$I = new ApiTester($scenario);
$I->wantTo('verify GET');
$I->sendGET('/search/regiao/geo/1');
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
$I->seeResponseIsJson();
