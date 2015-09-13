<?php

namespace Concise\Core;

use Concise\Core\TestCase;

class NoMatcherFoundExceptionTest extends TestCase
{
    public function testExtendsException()
    {
        $this->assert(new NoMatcherFoundException(array()))
            ->instanceOf('\Exception');
    }

    public function testSyntaxCanBeSetInConstructor()
    {
        $e = new NoMatcherFoundException(array('? foo ?'));
        $this->assert($e->getSyntaxes())->equals(array('? foo ?'));
    }

    public function testExceptionMessage()
    {
        $e = new NoMatcherFoundException(array('? foo ?'));
        $this->assert($e->getMessage())
            ->equals("No such matcher for syntax '? foo ?'.");
    }
}
