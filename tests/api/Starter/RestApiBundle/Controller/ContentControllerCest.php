<?php

use Symfony\Component\HttpFoundation\Response;
use \ApiTester;

/**
 * Class ContentControllerCest
 */
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

        $i->sendGET(Page\ApiContent::route('/555'));
        $i->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
        $i->seeResponseIsJson();
    }

    public function ensureDefaultResponseTypeIsJson(ApiTester $i)
    {
        $i->wantTo('ensure default response type is json');

        $i->sendGET(Page\ApiContent::route('/1'));
        $i->seeResponseCodeIs(Response::HTTP_OK);
        $i->seeResponseIsJson();
    }

    public function getValidContent(ApiTester $i)
    {
        foreach ($this->validContentProvider() as $id => $data) {
            $i->sendGET(Page\ApiContent::route('/' . $id . '.json'));
            $i->seeResponseCodeIs(Response::HTTP_OK);
            $i->seeResponseIsJson();

            $i->seeResponseContainsJson($data);
        }
    }

    public function getContentsCollection(ApiTester $i)
    {
        $i->sendGET(Page\ApiContent::$URL);
        $i->seeResponseCodeIs(Response::HTTP_OK);
        $i->seeResponseIsJson();
        $i->seeResponseContainsJson(array(
            array(
                'id' => 1,
                'title'  => 'home',
            ),
            array(
                'id' => 2,
                'title'  => 'about',
            )
        ));
    }

    public function getContentsCollectionWithLimit(ApiTester $i)
    {
        $i->sendGET(Page\ApiContent::route('?limit=1'));
        $i->seeResponseCodeIs(Response::HTTP_OK);
        $i->seeResponseIsJson();
        $i->seeResponseContainsJson(array(
            array(
                'id' => 1,
                'title'  => 'home',
            ),
        ));
    }

    public function getContentsCollectionWithOffset(ApiTester $i)
    {
        $i->sendGET(Page\ApiContent::route('?offset=1'));
        $i->seeResponseCodeIs(Response::HTTP_OK);
        $i->seeResponseIsJson();
        $i->seeResponseContainsJson(array(
            'title'  => 'about'
        ));
    }

    public function getContentsCollectionWithLimitAndOffset(ApiTester $i)
    {
        $i->sendGET(Page\ApiContent::route('?offset=1&limit=3'));
        $i->seeResponseCodeIs(Response::HTTP_OK);
        $i->seeResponseIsJson();
        $i->seeResponseContainsJson(array(
            'title'  => 'about'
        ));
    }

    public function postWithBadFieldsReturn400ErrorCode(ApiTester $i)
    {
        $i->sendPOST(Page\ApiContent::$URL, ['bad_field' => 'qwerty']);
        $i->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function goodPostReturns201WithHeader(ApiTester $i)
    {
        // add the time to the title so it's unique(ish)
        $title = 'api testing ' . date('H:i:s');
        $i->sendPOST(Page\ApiContent::$URL, ['title' => $title, 'body' => 'test has passed']);

        $id = $i->grabFromDatabase('contents', 'id', ['title' => $title]);

        $i->seeResponseCodeIs(Response::HTTP_CREATED);
        $i->canSeeHttpHeader('Location', Page\ApiContent::route('/' . $id));
    }


    private function validContentProvider()
    {
        return [1 => ['title' => 'home'], 2 => ['title' => 'about']];
    }
}
