<?php

namespace Starter\RestApiBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Starter\RestApiBundle\Exception\InvalidFormException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Starter\RestApiBundle\Entity\BaseEntity;

/**
 * Class FormHandler
 * @package Starter\RestApiBundle\Form\Handler
 */
class FormHandler
{

    private $entityManager;
    private $formFactory;
    private $formType;

    /**
     * FormHandler constructor.
     * @param ObjectManager $objectManager
     * @param FormFactoryInterface $formFactory
     * @param FormTypeInterface $formType
     */
    public function __construct(ObjectManager $objectManager, FormFactoryInterface $formFactory, FormTypeInterface $formType)
    {
        $this->entityManager = $objectManager;
        $this->formFactory = $formFactory;
        $this->formType = $formType;
    }


// not type hinting BaseEntity because we set the form type in the constructor and symfony error is returned if invalid object
// public function processForm(BaseEntity $object, array $parameters, $method)
    /**
     * @param $object
     * @param array $parameters
     * @param $method
     * @return \Symfony\Component\Form\FormInterface
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException (if any given option is not applicable to the given type)
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException (if the form has already been submitted)
     * @throws InvalidFormException (if the form is invalid)
     */
    public function processForm($object, array $parameters, $method)
    {
        // if no html, then no csrf protection is okay
        //TODO: perhaps set "'csrf_protection' => false" in the config.xml instead (eg. disable_csrf_role: ROLE_API)
        $options = ['method' => $method, 'csrf_protection' => false];
        $form = $this->formFactory->create($this->formType, $object, $options);

        $form->submit($parameters, $method !== 'PATCH');

        if (!$form->isValid()) {
            //exit($form->getErrors());
            throw new InvalidFormException($form);
        }

        $data = $form->getData();
        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}
