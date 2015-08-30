<?php

namespace Concise\Core;

use Concise\TestCase;

class DidNotMatchExceptionTest extends TestCase
{
    public function testIsATypeOfException()
    {
        $this->aassert(new DidNotMatchException())
            ->isAnInstanceOf('\Exception');
    }
}
