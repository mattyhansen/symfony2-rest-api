<?php

namespace Starter\RestApiBundle\Handler;

use Starter\RestApiBundle\Repository\ContentRepository;

/**
 * Class ContentHandler
 * @package Starter\RestApiBundle\Handler
 */
class ContentHandler extends BaseHandler
{
    /**
     * ContentHandler constructor.
     * @param ContentRepository $contentRepository
     */
    public function __construct(ContentRepository $contentRepository)
    {
        $this->repository = $contentRepository;
    }
}
