<?php

namespace Concise\Matcher;

use Concise\TestCase;

class SyntaxText extends TestCase
{
    public function testGetSyntax()
    {
        $syntax = new Syntax('? equals ?', 'stdClass::method');
        $this->assert($syntax->getSyntax(), equals, '? equals ?');
    }

    public function testGetClass()
    {
        $syntax = new Syntax('? equals ?', 'stdClass::method');
        $this->assert($syntax->getClass(), equals, 'stdClass');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Class 'FooBar' does not exist.
     */
    public function testClassMustExist()
    {
        new Syntax('? equals ?', 'FooBar');
    }

    public function testGetMethod()
    {
        $syntax = new Syntax('? equals ?', 'stdClass::method');
        $this->assert($syntax->getMethod(), equals, 'method');
    }

    public function testGetRawSyntax()
    {
        $syntax =
            new Syntax('?:int does not equal ?:string', 'stdClass::method');
        $this->assert($syntax->getRawSyntax(), equals, '? does not equal ?');
    }
}
