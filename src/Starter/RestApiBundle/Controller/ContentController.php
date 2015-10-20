<?php

namespace Starter\RestApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Starter\RestApiBundle\Entity\Content;
use Starter\RestApiBundle\Form\Type\ContentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ContentController
 * @package Starter\RestApiBundle\Controller
 */
//class ContentController extends BaseController
class ContentController extends BaseController
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
     *
     * @return \Starter\RestApiBundle\Entity\Content
     *
     * @throws NotFoundHttpException
     */
    public function getAction($id)
    {
        /**
         * Use "public function getAction($id)" if "implements ClassResourceInterface" for dynamic routing
         */

        return $this->getOr404($id, $this->getHandler());
    }

    /**
     * Returns a collection of Contents filtered by optional criteria
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Returns a collection of Contents",
     *  section="Contents",
     *  requirements={
     *      {"name"="limit", "dataType"="integer", "requirement"="\d+", "description"="the max number of records to return"}
     *  },
     *  parameters={
     *      {"name"="limit", "dataType"="integer", "required"=true, "description"="the max number of records to return"},
     *      {"name"="offset", "dataType"="integer", "required"=false, "description"="the record number to start results at"}
     *  }
     * )
     *
     * @QueryParam(name="limit", requirements="\d+", default="10", description="our limit")
     * @QueryParam(name="offset", requirements="\d+", nullable=true, default="0", description="our offset")
     *
     * @param Request $request
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return array
     */
    public function cgetAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        /**
         * Ensure "fos_rest: param_fetcher_listener: true" is set in the config.xml to allow for paramFetcher
         * see https://github.com/FriendsOfSymfony/FOSRestBundle/blob/master/Resources/doc/3-listener-support.rst
         */
        $limit = $paramFetcher->get('limit');
        $offset = $paramFetcher->get('offset');
        return $this->getHandler()->all($limit, $offset);
    }

    public function postAction(Request $request)
    {
        $form = $this->createForm(new ContentType(), new Content(), array(
            'method' => 'POST',
            'csrf_protection' => false
        ));

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            // exit($form->getErrors());
            return $form;
        }

        $content = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($content);
        $em->flush();

        return $this->redirectView(
            $this->generateUrl('get_content', array('id' => $content->getId())),
            Response::HTTP_CREATED
        );
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
