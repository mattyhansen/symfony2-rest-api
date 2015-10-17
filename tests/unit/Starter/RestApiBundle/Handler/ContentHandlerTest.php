<?php

class ContentHandlerTest extends \PHPUnit_Framework_TestCase
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
        $handler = $this->getHandler($repo);
        static::assertInstanceOf(
            '\Starter\RestApiBundle\Handler\ContentHandler',
            $handler
        );
    }

    public function testCanGetWithValidId()
    {
        $data = ['anything'];

        $repo = $this->getMockRepository();
        $repo->expects(static::once())
            ->method('find')
            ->will(static::returnValue($data));
        $handler = $this->getHandler($repo);

        static::assertEquals(
            $data,
            $handler->get(1)
        );
    }

    public function testCantGetWithInvalidId()
    {
        $repo = $this->getMockRepository();
        $repo->expects(static::once())
            ->method('find')
            ->will(static::returnValue(null));
        $handler = $this->getHandler($repo);

        static::assertNull($handler->get(100000));
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
     * @return \Starter\RestApiBundle\Handler\ContentHandler
     */
    private function getHandler($repo)
    {
        $handler = new \Starter\RestApiBundle\Handler\ContentHandler($repo);
        return $handler;
    }
}
