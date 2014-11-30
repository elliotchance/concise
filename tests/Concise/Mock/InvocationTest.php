<?php

namespace Concise\Mock;

use Concise\TestCase;

class InvocationTest extends TestCase
{
    /**
     * @group #182
     */
    public function testInvokeCountStartsWithOne()
    {
        $invocation = new Invocation();
        $this->assert($invocation->getInvokeCount(), equals, 1);
    }
}
