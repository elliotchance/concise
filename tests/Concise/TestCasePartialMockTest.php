<?php

namespace Concise;

use DateTime;

/**
 * @group mocking
 * @group #129
 */
class TestCasePartialMockTest extends TestCase
{
    public function testPartialMockReturnsMockBuilder()
    {
        $instance = new DateTime();
        $this->assert($this->partialMock($instance), instance_of, '\Concise\Mock\MockBuilder');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected object, but got string for argument 1
     */
    public function testPartialMockMustReceiveAnObject()
    {
        $this->partialMock('foo');
    }

    public function testPartialMockReturnsAnInstanceOfItself()
    {
        $instance = new DateTime();
        $mock = $this->partialMock($instance)->get();
        $this->assert($mock, instance_of, '\DateTime');
    }
}
