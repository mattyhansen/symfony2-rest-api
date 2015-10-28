<?php

namespace Starter\AppBundle\Provider;

/**
 * Interface ProviderInterface
 * @package Starter\AppBundle\Provider
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
