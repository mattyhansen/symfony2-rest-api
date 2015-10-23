<?php

use \Starter\RestApiBundle\Form\Handler\FormHandler;
use \Starter\RestApiBundle\Form\Type\ContentType;

/**
 * Class FormHandlerTest
 *
 * "extends \Codeception\TestCase\Test" so we have easy access to the service container
 */
class FormHandlerTest extends \Codeception\TestCase\Test
{
    /**
     * @var Symfony\Component\DependencyInjection\Container
     */
    private $serviceContainer;
    /**
     * @var Symfony\Component\Form\FormFactoryInterface
     */
    private $formFactory;

    protected function setUp()
    {
        parent::setUp();

        $this->serviceContainer = $this->getModule('Symfony2')->container;
        $this->formFactory = $this->serviceContainer->get('form.factory');
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    // tests

    public function testCanGrabFromServiceContainer()
    {
        static::assertInstanceOf(
            'Starter\RestApiBundle\Form\Handler\FormHandler',
            $this->serviceContainer->get('starter.rest_api_bundle.form.handler.content_form_handler')
        );
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp /Symfony\\Component\\Form\\FormTypeInterface/
     */
    public function testFormHandlerThrowsWhenGivenInvalidFormType()
    {
        new FormHandler($this->getMockEntityManager(), $this->formFactory, new \StdClass());
    }

    /**
     * @expectedException Symfony\Component\Form\Exception\LogicException
     * @expectedExceptionMessageRegExp /Starter\\RestApiBundle\\Entity\\Content/
     */
    public function testProcessFormThrowsWhenGivenInvalidObjectForAGivenFormType()
    {
        $formHandler = new FormHandler($this->getMockEntityManager(), $this->formFactory, new ContentType());
        $formHandler->processForm(new \StdClass(), [], 'POST');
    }

    /**
     * @expectedException Starter\RestApiBundle\Exception\InvalidFormException
     */
    public function testProcessFormReturnsWithErrorsWhenFormIsNotValid()
    {
        /**
         * Get Form
         */
        $mockForm = $this->getMockForm();

        /**
         * Create Form
         */
        /** @var \Symfony\Component\Form\FormFactoryInterface $formFactory */
        $formFactory = $this->getCreatedMockForm($mockForm);

        /**
         * Process Form
         */
        $formHandler = new FormHandler($this->getMockEntityManager(), $formFactory, new ContentType());
        $formHandler->processForm(new \Starter\RestApiBundle\Entity\Content(), [], 'POST');
    }


    public function testProcessFormReturnsValidObjectOnSuccess()
    {
        $formHandler = new FormHandler($this->getMockEntityManager(), $this->formFactory, new ContentType());

        $parameters = ['title' => 'main title', 'body' => 'yada yada yada'];
        static::assertInstanceOf(
            '\Starter\RestApiBundle\Entity\Content',
            $formHandler->processForm(new \Starter\RestApiBundle\Entity\Content(), $parameters, 'POST')
        );
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    private function getMockEntityManager()
    {
        /** @var \Doctrine\Common\Persistence\ObjectManager $em */
        $em = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        return $em;
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockForm()
    {
        $mockForm = $this->getMock('Symfony\Component\Form\FormInterface');
        $mockForm
            ->expects(static::once())
            ->method('submit');
        $mockForm
            ->expects(static::once())
            ->method('isValid')
            ->will(static::returnValue(false));
        return $mockForm;
    }

    /**
     * @param $mockForm
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getCreatedMockForm($mockForm)
    {
        $formFactory = $this->getMockBuilder('Symfony\Component\Form\FormFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $formFactory
            ->expects(static::once())
            ->method('create')
            ->will(static::returnValue($mockForm));
        return $formFactory;
    }
}
