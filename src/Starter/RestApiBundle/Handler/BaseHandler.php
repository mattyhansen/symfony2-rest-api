<?php

namespace Starter\RestApiBundle\Handler;

use Doctrine\ORM\EntityRepository;

class BaseHandler implements HandlerInterface
{
    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @param $id
     *
     * @return mixed
     */
    public function get($id)
    {
        return $this->repository->find($id);

    }

    /**
     * @param $limit
     * @param $offset
     *
     * @return array
     */
    public function all($limit, $offset)
    {
        return $this->repository->findBy([], [], $limit, $offset);
    }
}
