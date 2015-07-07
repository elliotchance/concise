<?php

namespace Concise\Syntax;

use Concise\TestCase;

class NoMatcherFoundExceptionTest extends TestCase
{
    public function testExtendsException()
    {
        $this->assert(
            new NoMatcherFoundException(array()),
            instance_of,
            '\Exception'
        );
    }

    public function testSyntaxCanBeSetInConstructor()
    {
        $e = new NoMatcherFoundException(array('? foo ?'));
        $this->assert($e->getSyntaxes(), equals, array('? foo ?'));
    }

    public function testExceptionMessage()
    {
        $e = new NoMatcherFoundException(array('? foo ?'));
        $this->assert(
            $e->getMessage(),
            equals,
            "No such matcher for syntax '? foo ?'."
        );
    }
}
