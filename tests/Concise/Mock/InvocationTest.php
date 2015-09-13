<?php

namespace Concise\Mock;

use Concise\Core\TestCase;

/**
 * @group #182
 */
class InvocationTest extends TestCase
{
    public function testInvokeCountStartsWithOne()
    {
        $invocation = new Invocation();
        /*$this->assert($invocation->getInvokeCount(), equals, 1);*/
        $this->assert($invocation->getInvokeCount())->equals(1);
    }

    public function testDefaultArgumentsIsEmpty()
    {
        $invocation = new Invocation();
        /*$this->assert($invocation->getArguments(), is_empty_array);*/
        $this->assert($invocation->getArguments())->isEmptyArray;
    }

    public function testImplementsInvocationInterface()
    {
        $invocation = new Invocation();
        /*$this->assert(
            $invocation,
            instance_of,
            '\Concise\Mock\InvocationInterface'
        );*/
        $this->assert($invocation)->instanceOf('\Concise\Mock\InvocationInterface');
    }

    public function testConstructorCanInitialiseInvokeCount()
    {
        $invocation = new Invocation(123);
        /*$this->assert($invocation->getInvokeCount(), equals, 123);*/
        $this->assert($invocation->getInvokeCount())->equals(123);
    }

    public function testConstructorCanInitialiseArguments()
    {
        $invocation = new Invocation(1, array('foo'));
        /*$this->assert($invocation->getArguments(), equals, array('foo'));*/
        $this->assert($invocation->getArguments())->equals(array('foo'));
    }

    public function testGetArgumentWillReturnFirstArgument()
    {
        $invocation = new Invocation(1, array('foo'));
        /*$this->assert($invocation->getArgument(0), equals, 'foo');*/
        $this->assert($invocation->getArgument(0))->equals('foo');
    }

    public function testGetArgumentWillReturnAnyArgumentByIndex()
    {
        $invocation = new Invocation(1, array('foo', 'bar'));
        /*$this->assert($invocation->getArgument(1), equals, 'bar');*/
        $this->assert($invocation->getArgument(1))->equals('bar');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid argument index: -1
     */
    public function testNegativeArgumentIndexWillThrowException()
    {
        $invocation = new Invocation();
        $invocation->getArgument(-1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid argument index: 0 (only 0 arguments)
     */
    public function testArgumentIndexGreaterThanAvailableWillThrowException()
    {
        $invocation = new Invocation();
        $invocation->getArgument(0);
    }

    public function testDefaultArgumentCountIsZero()
    {
        $invocation = new Invocation();
        /*$this->assert($invocation->getArgumentCount(), equals, 0);*/
        $this->assert($invocation->getArgumentCount())->equals(0);
    }

    public function testArgumentCountIsCorrect()
    {
        $invocation = new Invocation(1, array('foo', 'bar'));
        /*$this->assert($invocation->getArgumentCount(), equals, 2);*/
        $this->assert($invocation->getArgumentCount())->equals(2);
    }
}
