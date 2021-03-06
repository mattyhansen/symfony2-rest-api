<?php

namespace Starter\AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

use Starter\AppBundle\Entity\Content;
use Starter\AppBundle\Exception\InvalidFormException;

/**
 * Class ContentController
 * @package Starter\AppBundle\Controller
 */
class ContentController extends BaseController
{

    /**
     * Sets the Container associated with this Controller.
     *
     * @param ContainerInterface $container A ContainerInterface instance
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->dispatcher = $this->get('starter.app_bundle.content_dispatcher');
        $this->provider = $this->get('starter.app_bundle.content_provider');

    }

    /**
     * Returns content when given a valid id
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Retrieves content by id",
     *  output = "Starter\AppBundle\Entity\Content",
     *  section="Contents",
     *  statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the requested Content is not found"
     *     }
     * )
     *
     * @View("data.html.twig")
     *
     * @param $id
     *
     * @return \Starter\AppBundle\Entity\Content
     *
     * @throws NotFoundHttpException
     */
    public function getAction($id)
    {
        /**
         * Use "public function getAction($id)" if "implements ClassResourceInterface" for dynamic routing
         */
        return $this->getOr404($id);
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
     * @View()
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
        return $this->provider->all($limit, $offset);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Creates a new Content",
     *  input = "Starter\Content\Form\Type\ContentFormType",
     *  output = "Starter\AppBundle\Entity\Content",
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
            $content = $this->dispatcher->post($request->request->all());
            $routeOptions = [
                'id' => $content->getId(),
                '_format' => $request->get('_format')
            ];
            return $this->routeRedirectView('get_content', $routeOptions, Response::HTTP_CREATED);

        } catch (InvalidFormException $e) {
            return $e->getForm();
        }
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Replaces an existing Content",
     *  input = "Starter\Content\Form\Type\ContentFormType",
     *  output = "Starter\AppBundle\Entity\Content",
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
     *
     * @throws AlreadySubmittedException
     * @throws InvalidOptionsException
     */
    public function putAction(Request $request, $id)
    {
        //return new Response(null, Response::HTTP_BAD_REQUEST);
        /** @var Content $content */
        $content = $this->provider->get($id);
        try {
            if ($content === null) {
                $statusCode = Response::HTTP_CREATED;
                $content = $this->dispatcher->post($request->request->all());
            } else {
                $statusCode = Response::HTTP_NO_CONTENT;
                $content = $this->dispatcher->put($content, $request->request->all());
            }
            $routeOptions = [
                'id' => $content->getId(),
                '_format' => $request->get('_format')
            ];
            return $this->routeRedirectView('get_content', $routeOptions, $statusCode);

        } catch (InvalidFormException $e) {
            return $e->getForm();
        }
    }


    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Patches a Content",
     *  input = "Starter\Content\Form\Type\ContentFormType",
     *  output = "Starter\AppBundle\Entity\Content",
     *  section="Contents",
     *  statusCodes={
     *         201="Returned when a new Content has been successfully created",
     *         400="Returned when the posted data is invalid"
     *     }
     * )
     *
     * //NOTE: This implementation of patch doesn't follow the RESTful convention 100% correctly,
     *         but is okay for now (see http://williamdurand.fr/2014/02/14/please-do-not-patch-like-an-idiot/)
     *
     * @View()
     *
     * @param Request $request
     * @param $id
     * @return \FOS\RestBundle\View\View|null
     *
     * @throws AlreadySubmittedException
     * @throws InvalidOptionsException
     * @throws NotFoundHttpException
     */
    public function patchAction(Request $request, $id)
    {
        try {
            /** @var Content $content */
            $content = $this->getOr404($id);
            $content = $this->dispatcher->patch($content, $request->request->all());
            $routeOptions = [
                'id' => $content->getId(),
                '_format' => $request->get('_format')
            ];
            return $this->routeRedirectView('get_content', $routeOptions, Response::HTTP_NO_CONTENT);

        } catch (InvalidFormException $e) {
            return $e->getForm();
        }
    }


    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Deletes an existing Content",
     *  section="Contents",
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="the id of the Content to delete"}
     *  },
     *  statusCodes={
     *         204="Returned when an existing Content has been successfully deleted",
     *         404="Returned when trying to delete a non existent Content"
     *     }
     * )
     *
     * @param Request $request
     * @param $id
     *
     * @throws NotFoundHttpException
     */
    public function deleteAction(Request $request, $id)
    {
        /** @var Content $content */
        $content = $this->getOr404($id);
        $this->dispatcher->delete($content);
    }
}
