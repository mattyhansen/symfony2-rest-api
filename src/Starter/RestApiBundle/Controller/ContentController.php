<?php

namespace Starter\RestApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

use Starter\RestApiBundle\Entity\Content;
use Starter\RestApiBundle\Exception\InvalidFormException;

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
        return $this->getResponse($id, $this->getDispatcher());
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
        return $this->getDispatcher()->all($limit, $offset);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Creates a new Content",
     *  input = "Starter\RestApiBundle\Form\Type\ContentFormType",
     *  output = "Starter\RestApiBundle\Entity\Content",
     *  section="Contents",
     *  statusCodes={
     *         201="Returned when a new Content has been successfully created",
     *         400="Returned when the posted data is invalid"
     *     }
     * )
     *
     * @View()
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View|null
     *
     * @throws AlreadySubmittedException
     * @throws InvalidOptionsException
     */
    public function postAction(Request $request)
    {
        try {
            /** @var Content $content */
            $content = $this->getDispatcher()->post($request->request->all());
            $routeOptions = ['id' => $content->getId(), '_format' => $request->get('_format')];
            return $this->routeRedirectView('get_content', $routeOptions, Response::HTTP_CREATED);

        } catch (InvalidFormException $e) {
            return $e->getForm();
        }
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Replaces an existing Content",
     *  input = "Starter\RestApiBundle\Form\Type\ContentFormType",
     *  output = "Starter\RestApiBundle\Entity\Content",
     *  section="Contents",
     *  statusCodes={
     *         201="Returned when a new Content has been successfully created",
     *         204="Returned when an existing Content has been successfully updated",
     *         400="Returned when the posted data is invalid"
     *     }
     * )
     *
     * @param Request $request
     * @param $id
     * @return array|\FOS\RestBundle\View\View|null
     */
    public function putAction(Request $request, $id)
    {
        //return new Response(null, Response::HTTP_BAD_REQUEST);
        /** @var Content $content */
        $content = $this->getDispatcher()->get($id);
        try {
            if ($content === null) {
                $statusCode = Response::HTTP_CREATED;
                $content = $this->getDispatcher()->post($request->request->all());
            } else {
                $statusCode = Response::HTTP_NO_CONTENT;
                $content = $this->getDispatcher()->put($content, $request->request->all());
            }
            $routeOptions = ['id' => $content->getId(), '_format' => $request->get('_format')];
            return $this->routeRedirectView('get_content', $routeOptions, $statusCode);

        } catch (InvalidFormException $e) {
            return $e->getForm();
        }
    }



    /**
     * @return \Starter\RestApiBundle\Dispatcher\ContentDispatcher
     */
    private function getDispatcher()
    {
        $dispatcher = $this->get('starter.rest_api_bundle.content_dispatcher');
        return $dispatcher;
    }
}
