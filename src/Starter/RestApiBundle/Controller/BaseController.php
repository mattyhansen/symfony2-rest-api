<?php

namespace Starter\RestApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Starter\RestApiBundle\Handler\BaseHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class BaseController
 * @package Starter\RestApiBundle\Controller
 */
class BaseController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @param $id
     * @param BaseHandler $handler
     *
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id, BaseHandler $handler)
    {
        $content = $handler->get($id);

        if ($content === null) {
            throw new NotFoundHttpException();
        }

        return $content;
    }
}
