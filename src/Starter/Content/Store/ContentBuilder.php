<?php

namespace Starter\Content\Store;

/**
 * Class ContentBuilder
 * @package Starter\Content\Store
 */
class ContentBuilder
{

    /**
     * @param $id
     * @return mixed
     */
    public function getContentValueObject($id)
    {
        $content = new ContentValueObject();
        $content->setId($id);

        return $id;
    }
}
