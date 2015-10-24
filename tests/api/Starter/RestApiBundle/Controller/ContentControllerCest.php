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

    /**
     * GET TESTING
     */

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
        $i->sendGET(Page\ApiContent::route());
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

    public function getContentsCollectionWithHateoasSelfHref(ApiTester $i)
    {
        $i->sendGET(Page\ApiContent::route());
        $i->seeResponseCodeIs(Response::HTTP_OK);
        $i->seeResponseIsJson();
        $i->seeResponseContainsJson(array(
            'href'  => '/api/contents/1'
        ));
    }

    /**
     * POST TESTING
     */

    public function postWithEmptyFieldsReturns400ErrorCode(ApiTester $i)
    {
        $i->sendPOST(Page\ApiContent::route(), array());

        $i->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }


    public function postWithBadFieldsReturn400ErrorCode(ApiTester $i)
    {
        $i->sendPOST(Page\ApiContent::route(), ['bad_field' => 'qwerty']);
        $i->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function postWithValidDataReturns201WithHeader(ApiTester $i)
    {
        // add the time to the title so it's unique(ish)
        $title = 'api testing ' . date('H:i:s');
        $i->sendPOST(Page\ApiContent::route(), ['title' => $title, 'body' => 'test has passed']);

        $id = $i->grabFromDatabase('contents', 'id', ['title' => $title]);

        $i->seeResponseCodeIs(Response::HTTP_CREATED);
        // full route is required because the location returns the full url
        $i->canSeeHttpHeader('Location', Page\ApiContent::fullRoute('/' . $id));
    }

    /**
     * PUT TESTING
     */

    public function putWithInvalidIdAndInvalidDataReturns400ErrorCode(ApiTester $i)
    {
        $i->sendPUT(Page\ApiContent::route('/214234.json'), array(
            'qwerty' => 'asdfgh',
        ));

        $i->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function putWithInvalidIdAndValidDataCreatesNewResourceAndReturns201(ApiTester $i)
    {
        $title = 'example with invalid id';
        $body = 'and valid data';

        $i->sendPUT(Page\ApiContent::route('/5555.json'), array(
            'title' => $title,
            'body' => $body,
        ));

        $id = $i->grabFromDatabase('contents', 'id', array(
            'title'  => $title
        ));

        $i->seeResponseCodeIs(Response::HTTP_CREATED);
        $i->canSeeHttpHeader('Location', Page\ApiContent::fullRoute('/' . $id));
    }

    public function putWithValidIdAndInvalidDataReturns400ErrorCode(ApiTester $i)
    {
        $i->sendPUT(Page\ApiContent::route('/2.json'), array(
            'ytrewq' => 'qwerty',
        ));

        $i->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function putWithValidIdAndValidDataReplacesExistingDataAndReturns204(ApiTester $i)
    {
        $title = 'valid id - new and improved title';
        $body = 'valid data - new content here';

        $i->sendPUT(Page\ApiContent::route('/2.json'), array(
            'title' => $title,
            'body' => $body,
        ));

        $newTitle = $i->grabFromDatabase('contents', 'title', array(
            'id'  => 2
        ));

        $i->seeResponseCodeIs(Response::HTTP_NO_CONTENT);
        // full route is required because the location returns the full url
        $i->canSeeHttpHeader('Location', Page\ApiContent::fullRoute('/2'));
        $i->assertEquals($title, $newTitle);
    }


    /**
     * @return array
     */
    private function validContentProvider()
    {
        return [1 => ['title' => 'home'], 2 => ['title' => 'about']];
    }
}
