<?php

namespace Starter\RestApiBundle\Dispatcher;

use Starter\RestApiBundle\Entity\Content;
use Starter\RestApiBundle\Form\Handler\FormHandler;
use Starter\RestApiBundle\Repository\ContentRepository;

/**
 * Class ContentDispatcher
 * @package Starter\RestApiBundle\Dispatcher
 */
class ContentDispatcher extends BaseDispatcher
{
    /**
     * ContentDispatcher constructor.
     * @param ContentRepository $contentRepository
     * @param FormHandler $formHandler
     */
    public function __construct(ContentRepository $contentRepository, FormHandler $formHandler)
    {
        $this->repository = $contentRepository;
        $this->formHandler = $formHandler;
        $this->object = new Content();
    }
}
