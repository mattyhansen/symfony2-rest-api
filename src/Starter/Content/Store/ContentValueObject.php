<?php

namespace Starter\Content\Store;

/**
 * Class ContentValueObject
 * @package Starter\Content\Store
 */
class ContentValueObject
{
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ContentValueObject
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}
