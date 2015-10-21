<?php

class ContentDispatcherTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    // tests
    public function testCanConstruct()
    {
        $repo = $this->getMockRepository();
        $dispatcher = $this->getDispatcher($repo);
        static::assertInstanceOf(
            '\Starter\RestApiBundle\Dispatcher\ContentDispatcher',
            $dispatcher
        );
    }

    public function testCanGetWithValidId()
    {
        $data = ['anything'];

        $repo = $this->getMockRepository();
        $repo->expects(static::once())
            ->method('find')
            ->will(static::returnValue($data));
        $dispatcher = $this->getDispatcher($repo);

        static::assertEquals(
            $data,
            $dispatcher->get(1)
        );
    }

    public function testCantGetWithInvalidId()
    {
        $repo = $this->getMockRepository();
        $repo->expects(static::once())
            ->method('find')
            ->will(static::returnValue(null));
        $dispatcher = $this->getDispatcher($repo);

        static::assertNull($dispatcher->get(100000));
    }

    public function testCanGetAll()
    {
        $data = [1,2];

        $repo = $this->getMockRepository();
        $repo->expects(static::once())
            ->method('findBy')
            ->will(static::returnValue($data));

        $dispatcher = $this->getDispatcher($repo);
        static::assertEquals(
            $data,
            $dispatcher->all(1, 1)
        );
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockRepository()
    {
        $repo = $this->getMockBuilder('Starter\RestApiBundle\Repository\ContentRepository')
            ->disableOriginalConstructor()
            ->getMock();
        return $repo;
    }

    /**
     * @param $repo
     * @return \Starter\RestApiBundle\Dispatcher\ContentDispatcher
     */
    private function getDispatcher($repo)
    {
        $dispatcher = new \Starter\RestApiBundle\Dispatcher\ContentDispatcher($repo);
        return $dispatcher;
    }
}
