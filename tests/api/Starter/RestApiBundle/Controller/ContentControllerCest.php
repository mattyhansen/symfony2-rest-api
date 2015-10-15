<?php
use \ApiTester;

class ContentControllerCest
{
    public function _before(ApiTester $i)
    {
    }

    public function _after(ApiTester $i)
    {
    }

    // tests
    public function getInvalidContent(ApiTester $i)
    {
        $i->wantTo('ensure Getting an invalid Content id returns a 404 code');

        $i->sendGET('/api/contents/555');
        $i->seeResponseCodeIs(404);
        $i->seeResponseIsJson();
    }
}
