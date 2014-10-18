<?php

namespace Concise\Syntax;

use Concise\TestCase;

class NoMatcherFoundExceptionTest extends TestCase
{
    public function testExtendsException()
    {
        $this->assert(new NoMatcherFoundException(), instance_of, '\Exception');
    }

    public function testSyntaxIsNullIfNotSet()
    {
        $e = new NoMatcherFoundException();
        $this->assert($e->getSyntax(), is_null);
    }
}
