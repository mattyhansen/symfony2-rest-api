<?php

namespace Starter\RestApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Starter\RestApiBundle\Dispatcher\BaseDispatcher;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class BaseController
 *
 * By using "implements ClassResourceInterface" we can omit the Class name from the action methods
 * "class ContentController extends FOSRestController implements ClassResourceInterface"
 * For example, "getAction" instead of "getContentAction" and "cgetAction" instead of "getContentsAction"
 * see: http://symfony.com/doc/master/bundles/FOSRestBundle/5-automatic-route-generation_single-restful-controller.html#implicit-resource-name-definition
 *
 * Using this controller as the routing.yml resource, will tell Symfony2 to automatically generate proper REST routes
 * from this controller action names.
 * Notice "type: rest" option (in routing.yml) is required so that the RestBundle can find which routes are supported.
 * see: http://symfony.com/doc/master/bundles/FOSRestBundle/5-automatic-route-generation_single-restful-controller.html#single-restful-controller-routes
 *
 *
 * @package Starter\RestApiBundle\Controller
 */
class BaseController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @param $id
     * @param BaseDispatcher $dispatcher
     *
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id, BaseDispatcher $dispatcher)
    {
        $content = $dispatcher->get($id);

        if ($content === null) {
            throw new NotFoundHttpException();
        }

        return $content;
    }
}
