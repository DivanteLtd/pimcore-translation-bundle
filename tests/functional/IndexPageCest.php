<?php

namespace Tests\Functional;

use Tests\FunctionalTester;

class IndexPageCest
{
    public function testFrontpage(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->canSeeResponseCodeIs(200);
    }
}
