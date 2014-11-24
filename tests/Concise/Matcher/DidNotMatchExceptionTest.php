<?php

namespace Concise\Matcher;

use Concise\TestCase;

class DidNotMatchExceptionTest extends TestCase
{
    public function testIsATypeOfException()
    {
        $this->assert(new DidNotMatchException(), is_an_instance_of, '\Exception');
    }
}
