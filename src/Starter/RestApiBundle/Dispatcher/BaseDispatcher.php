<?php

namespace Starter\RestApiBundle\Dispatcher;

use Doctrine\ORM\EntityRepository;

/**
 * Class BaseDispatcher
 * @package Starter\RestApiBundle\Dispatcher
 */
class BaseDispatcher implements DispatcherInterface
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
