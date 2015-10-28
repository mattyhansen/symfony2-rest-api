<?php

namespace Starter\Content\Provider;

use Starter\AppBundle\Provider\BaseProvider;
use Starter\AppBundle\Form\Handler\FormHandler;
use Starter\AppBundle\Entity\Content;
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
