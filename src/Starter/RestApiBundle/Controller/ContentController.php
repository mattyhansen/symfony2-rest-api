<?php

namespace Starter\RestApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ContentController
 * @package Starter\RestApiBundle\Controller
 */
class ContentController extends FOSRestController
{

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getContentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('StarterRestApiBundle:Content')->find($id);

        if ($content === null) {
            throw new NotFoundHttpException();
        }
        $view = new View($content);

        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
