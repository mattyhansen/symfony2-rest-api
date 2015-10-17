<?php

namespace Starter\RestApiBundle\Model;

interface ContentInterface
{

    /**
     * Returns Content title
     *
     * @return mixed
     */
    public function getTitle();

    /**
     * Returns Content Content
     *
     * @return mixed
     */
    public function getBody();
}
