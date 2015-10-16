<?php

use Symfony\Component\HttpFoundation\Response;
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
        $i->wantTo('ensure getting an invalid Content id returns a 404 code');

        $i->sendGET('/api/contents/555');
        $i->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
        $i->seeResponseIsJson();
    }

    public function getValidContent(ApiTester $i)
    {
        $i->wantTo('ensure getting a valid Content id returns a 200 code');

        $i->sendGET('/api/contents/1.json');
        $i->seeResponseCodeIs(Response::HTTP_OK);
        $i->seeResponseIsJson();
    }

    public function ensureDefaultResponseTypeIsJson(ApiTester $i)
    {
        $i->wantTo('ensure default response type is json');

        $i->sendGET('/api/contents/1');
        $i->seeResponseCodeIs(Response::HTTP_OK);
        $i->seeResponseIsJson();
    }
}
