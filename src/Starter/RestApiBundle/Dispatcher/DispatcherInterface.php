<?php

namespace Starter\RestApiBundle\Dispatcher;

use Starter\RestApiBundle\Model\ContentInterface;

interface DispatcherInterface
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
