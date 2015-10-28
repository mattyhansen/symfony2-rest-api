<?php

namespace Starter\RestApiBundle\Provider;

use Starter\RestApiBundle\Exception\InvalidFormException;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

use Doctrine\ORM\EntityRepository;
use Starter\RestApiBundle\Entity\BaseEntity;
use Starter\RestApiBundle\Form\Handler\FormHandler;

/**
 * Class BaseProvider
 * @package Starter\RestApiBundle\Provider
 */
class BaseProvider implements ProviderInterface
{
    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var FormHandler
     */
    protected $formHandler;

    /**
     * @var BaseEntity
     */
    protected $object;

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
