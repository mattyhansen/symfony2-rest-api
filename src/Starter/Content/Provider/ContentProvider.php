<?php

namespace Starter\Content\Provider;

use Starter\RestApiBundle\Provider\BaseProvider;
use Starter\RestApiBundle\Form\Handler\FormHandler;
use Starter\RestApiBundle\Entity\Content;
use Starter\Content\Repository\ContentRepository;

/**
 * Class ContentProvider
 * @package Starter\Content\Provider
 */
class ContentProvider extends BaseProvider
{
    /**
     * ContentProvider constructor.
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
