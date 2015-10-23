<?php

namespace Starter\RestApiBundle\Dispatcher;

use Starter\RestApiBundle\Exception\InvalidFormException;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

use Doctrine\ORM\EntityRepository;
use Starter\RestApiBundle\Entity\BaseEntity;
use Starter\RestApiBundle\Form\Handler\FormHandler;

/**
 * Class BaseDispatcher
 * @package Starter\RestApiBundle\Dispatcher
 */
class BaseDispatcher implements DispatcherInterface
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

    /**
     * @param array $parameters
     * @return \Symfony\Component\Form\FormInterface
     *
     * @throws InvalidFormException
     * @throws AlreadySubmittedException
     * @throws InvalidOptionsException
     */
    public function post(array $parameters)
    {
        return $this->formHandler->processForm($this->object, $parameters, 'POST');
    }
}
