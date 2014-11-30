<?php

namespace Concise\Mock;

use Concise\TestCase;

/**
 * @group #182
 */
class InvocationTest extends TestCase
{
    public function testInvokeCountStartsWithOne()
    {
        $invocation = new Invocation();
        $this->assert($invocation->getInvokeCount(), equals, 1);
    }

    public function testDefaultArgumentsIsEmpty()
    {
        $invocation = new Invocation();
        $this->assert($invocation->getArguments(), is_empty_array);
    }

    public function testImplementsInvocationInterface()
    {
        $invocation = new Invocation();
        $this->assert($invocation, instance_of, '\Concise\Mock\InvocationInterface');
    }

    public function testConstructorCanInitialiseInvokeCount()
    {
        $invocation = new Invocation(123);
        $this->assert($invocation->getInvokeCount(), equals, 123);
    }

    public function testConstructorCanInitialiseArguments()
    {
        $invocation = new Invocation(1, array('foo'));
        $this->assert($invocation->getArguments(), equals, array('foo'));
    }

    public function testGetArgumentWillReturnFirstArgument()
    {
        $invocation = new Invocation(1, array('foo'));
        $this->assert($invocation->getArgument(0), equals, 'foo');
    }

    public function testGetArgumentWillReturnAnyArgumentByIndex()
    {
        $invocation = new Invocation(1, array('foo', 'bar'));
        $this->assert($invocation->getArgument(1), equals, 'bar');
    }
}
