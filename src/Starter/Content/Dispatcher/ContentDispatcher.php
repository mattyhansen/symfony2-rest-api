<?php

namespace Starter\Content\Dispatcher;

use Starter\AppBundle\Dispatcher\BaseDispatcher;
use Starter\AppBundle\Form\Handler\FormHandler;
use Starter\AppBundle\Entity\Content;
use Starter\Content\Repository\ContentRepository;

/**
 * Class ContentDispatcher
 * @package Starter\Content\Dispatcher
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
