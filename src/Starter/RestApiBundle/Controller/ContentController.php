<?php

namespace Starter\RestApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 *
 * By using "implements ClassResourceInterface" we can omit the Class name from the action methods
 * "class ContentController extends FOSRestController implements ClassResourceInterface"
 * For example, "getAction" instead of "getContentAction" and "cgetAction" instead of "getContentsAction"
 * see: http://symfony.com/doc/master/bundles/FOSRestBundle/5-automatic-route-generation_single-restful-controller.html#implicit-resource-name-definition
 *
 * Using this controller as the routing.yml resource, will tell Symfony2 to automatically generate proper REST routes
 * from this controller action names.
 * Notice "type: rest" option is required so that the RestBundle can find which routes are supported.
 * see: http://symfony.com/doc/master/bundles/FOSRestBundle/5-automatic-route-generation_single-restful-controller.html#single-restful-controller-routes
 *
 * Class ContentController
 * @package Starter\RestApiBundle\Controller
 */
class ContentController extends BaseController
{

    /**
     * Returns content when given a valid id
     * //TODO: use "public function getAction($id)" if "implements ClassResourceInterface"
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Retrieves content by id",
     *  output = "Starter\RestApiBundle\Entity\Content",
     *  section="Contents",
     *  statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the requested Content is not found"
     *     }
     * )
     *
     * @View()
     *
     * @param $id
     * @return \Starter\RestApiBundle\Entity\Content
     * @throws NotFoundHttpException
     */
    public function getContentAction($id)
    {
        return $this->getOr404($id, $this->getHandler());
    }

    /**
     * @return \Starter\RestApiBundle\Handler\ContentHandler
     */
    private function getHandler()
    {
        $handler = $this->get('starter.rest_api_bundle.content_handler');
        return $handler;
    }
}
