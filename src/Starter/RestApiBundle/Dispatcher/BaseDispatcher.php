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

    /**
     * @param BaseEntity $baseEntity
     * @param array $parameters
     * @return \Symfony\Component\Form\FormInterface
     */
    public function put(BaseEntity $baseEntity, array $parameters)
    {
        return $this->formHandler->processForm($baseEntity, $parameters, 'PUT');
    }

    /**
     * @param BaseEntity $baseEntity
     * @param array $parameters
     * @return \Symfony\Component\Form\FormInterface
     */
    public function patch(BaseEntity $baseEntity, array $parameters)
    {
        return $this->formHandler->processForm($baseEntity, $parameters, 'PATCH');
    }

    /**
     * @param BaseEntity $baseEntity
     * @return mixed
     */
    public function delete(BaseEntity $baseEntity)
    {
        return $this->formHandler->delete($baseEntity);
    }
}
