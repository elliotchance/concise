<?php

namespace Concise\Core;

use Concise\Core\TestCase;

class DidNotMatchExceptionTest extends TestCase
{
    public function testIsATypeOfException()
    {
        $this->assert(new DidNotMatchException())
            ->isAnInstanceOf('\Exception');
    }
}
