<?php

namespace Starter\RestApiBundle\Dispatcher;

use Starter\RestApiBundle\Entity\BaseEntity;
use Starter\Content\Model\ContentInterface;

/**
 * Interface DispatcherInterface
 * @package Starter\RestApiBundle\Dispatcher
 */
interface DispatcherInterface
{
    /**
     * @param array $parameters
     * @return mixed
     */
    public function post(array $parameters);

    /**
     * @param BaseEntity $baseEntity
     * @param array $parameters
     * @return mixed
     */
    public function put(BaseEntity $baseEntity, array $parameters);

    /**
     * @param BaseEntity $baseEntity
     * @param array $parameters
     * @return mixed
     */
    public function patch(BaseEntity $baseEntity, array $parameters);

    /**
     * @param BaseEntity $baseEntity
     * @return mixed
     */
    public function delete(BaseEntity $baseEntity);
}
