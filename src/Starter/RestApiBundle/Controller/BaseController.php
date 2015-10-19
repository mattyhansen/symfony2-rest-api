<?php

namespace Starter\RestApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
//use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Starter\RestApiBundle\Handler\HandlerInterface;

/**
 * Class BaseController
 * @package Starter\RestApiBundle\Controller
 */
class BaseController extends FOSRestController
{

    /**
     * @param $id
     * @param HandlerInterface $handler
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function getOr404($id, HandlerInterface $handler)
    {
        $content = $handler->get($id);

        if ($content === null) {
            throw new NotFoundHttpException();
        }

        return $content;
    }
}
