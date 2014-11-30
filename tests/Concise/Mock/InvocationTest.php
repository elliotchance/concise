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
}
