<?php

namespace Starter\RestApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
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
     * @View()
     *
     * @param $id
     * @return \Starter\RestApiBundle\Entity\Content
     */
    public function getContentAction($id)
    {
        return $this->getOr404($id);
    }

    /**
     * //TODO: move to BaseController
     *
     * @param $id
     * @return mixed
     */
    private function getOr404($id)
    {
        $content = $this->getHandler()->get($id);

        if ($content === null) {
            throw new NotFoundHttpException();
        }

        return $content;
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
