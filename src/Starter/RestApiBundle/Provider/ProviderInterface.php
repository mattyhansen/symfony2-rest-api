<?php

namespace Starter\RestApiBundle\Provider;

/**
 * Interface ProviderInterface
 * @package Starter\RestApiBundle\Provider
 */
interface ProviderInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function get($id);

    /**
     * @param $limit
     * @param $offset
     * @return mixed
     */
    public function all($limit, $offset);
}
