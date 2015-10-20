<?php

namespace Starter\RestApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ContentType
 *
 * Generated with "app/console doctrine:generate:form StarterRestApiBundle:Content" (and then moved to Type folder)
 *
 * @package Starter\RestApiBundle\Form
 */
class ContentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('body')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Starter\RestApiBundle\Entity\Content'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'starter_restapibundle_content';
    }
}
