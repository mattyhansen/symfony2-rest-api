<?php

namespace Starter\RestApiBundle\Model;

interface PageInterface
{

    /**
     * Returns Page title
     *
     * @return mixed
     */
    public function getTitle();

    /**
     * Returns Page Content
     *
     * @return mixed
     */
    public function getContent();


}