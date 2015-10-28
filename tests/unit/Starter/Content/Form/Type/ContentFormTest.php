<?php

/**
 * Class FormHandlerTest
 *
 * "extends \Codeception\TestCase\Test" so we have easy access to the service container
 */
class ContentFormTest extends \Symfony\Component\Form\Test\TypeTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {

    }

    // tests

    /**
     * Based on: http://symfony.com/doc/current/cookbook/form/unit_testing.html
     */
    public function testSubmitValidData()
    {
        $formData = array(
            'title' => 'test',
            'body' => 'test2',
        );

        $type = new \Starter\Content\Form\Type\ContentType();
        $form = $this->factory->create($type);

        $object = new \Starter\RestApiBundle\Entity\Content();
        $object
            ->setTitle($formData['title'])
            ->setBody($formData['body']);

        // submit the data to the form directly
        $form->submit($formData);

        static::assertTrue($form->isSynchronized());
        static::assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            static::assertArrayHasKey($key, $children);
        }
    }
}
