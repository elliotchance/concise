<?php

namespace Concise;

use DateTime;

class TestCasePartialMockObject
{
    public $public;

    protected $foo;

    private $secret;

    public function init()
    {
        $this->public = 'yes';
        $this->foo = 'bar';
        $this->secret = 'baz';
    }
}

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

    public function testPartialMockWillInheritObjectValuesToMaintainState()
    {
        $instance = new TestCasePartialMockObject();
        $instance->init();
        $mock = $this->partialMock($instance)->get();
        $this->assert($this->getProperty($mock, 'public'), equals, 'yes');
    }

    public function testPartialMockWillInheritProtectedObjectValuesToMaintainState()
    {
        $instance = new TestCasePartialMockObject();
        $instance->init();
        $mock = $this->partialMock($instance)->get();
        $this->assert($this->getProperty($mock, 'foo'), equals, 'bar');
    }

    public function testPartialMockWillInheritPrivateObjectValuesToMaintainState()
    {
        $instance = new TestCasePartialMockObject();
        $instance->init();
        $mock = $this->partialMock($instance)->get();
        $this->assert($this->getProperty($mock, 'secret'), equals, 'baz');
    }
}
