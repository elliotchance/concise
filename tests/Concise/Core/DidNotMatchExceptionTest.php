<?php

namespace Concise\Core;

use Concise\TestCase;

class DidNotMatchExceptionTest extends TestCase
{
    public function testIsATypeOfException()
    {
        $this->assert(new DidNotMatchException())
            ->isAnInstanceOf('\Exception');
    }
}
