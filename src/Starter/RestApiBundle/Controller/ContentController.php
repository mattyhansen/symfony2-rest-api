<?php

namespace Starter\RestApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

/**
 * Class ContentController
 * @package Starter\RestApiBundle\Controller
 */
class ContentController extends FOSRestController
{

    public function getContentAction()
    {
        $data = array('id' => 1, 'title' => 'test', 'body' => 'content');
        $view = new View($data);

        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
