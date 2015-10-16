<?php

namespace Starter\RestApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ContentController
 * @package Starter\RestApiBundle\Controller
 */
class ContentController extends FOSRestController
{

    /**
     * Returns content when given a valid id
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
