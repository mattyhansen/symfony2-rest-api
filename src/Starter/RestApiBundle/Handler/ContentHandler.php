<?php

namespace Starter\RestApiBundle\Handler;

use Starter\RestApiBundle\Entity\Content;
use Starter\RestApiBundle\Form\Handler\FormHandler;
use Starter\RestApiBundle\Model\ContentInterface;
use Starter\RestApiBundle\Repository\ContentRepository;

class ContentHandler implements HandlerInterface
{
    private $repository;

    /**
     * ContentHandler constructor.
     * @param ContentRepository $contentRepository
     */
    public function __construct(ContentRepository $contentRepository)
    {
        $this->repository = $contentRepository;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->repository->find($id);

    }

    /**
     * @param $limit
     * @param $offset
     * @return array
     */
    public function all($limit, $offset)
    {
        return $this->repository->findBy([], [], $limit, $offset);
    }
}
