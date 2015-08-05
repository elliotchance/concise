<?php

namespace Concise\Matcher;

use Concise\TestCase;

class SyntaxText extends TestCase
{
    public function testGetSyntax()
    {
        $syntax = new Syntax('? equals ?');
        $this->assert($syntax->getSyntax(), equals, '? equals ?');
    }

    public function testGetClass()
    {
        $syntax = new Syntax('? equals ?', 'stdClass');
        $this->assert($syntax->getClass(), equals, 'stdClass');
    }
}
