<?php

namespace Starter\RestApiBundle\Dispatcher;

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
     */
    public function __construct(ContentRepository $contentRepository)
    {
        $this->repository = $contentRepository;
    }
}
