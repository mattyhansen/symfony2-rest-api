<?php

namespace Starter\RestApiBundle\Handler;

use Starter\RestApiBundle\Model\ContentInterface;

interface HandlerInterface
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
