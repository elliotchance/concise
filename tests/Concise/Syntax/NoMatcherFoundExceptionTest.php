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

    public function testSyntaxCanBeSetInConstructor()
    {
        $e = new NoMatcherFoundException('? foo ?');
        $this->assert($e->getSyntax(), equals, '? foo ?');
    }

    public function testExceptionMessage()
    {
        $e = new NoMatcherFoundException('? foo ?');
        $this->assert($e->getMessage(), equals, "No such matcher for syntax '? foo ?'.");
    }
}
