<?php

namespace Concise\Mock;

use \Concise\TestCase;
use \Concise\Mock\Action\ReturnValueAction;

interface ClassCompilerMock4
{
}

class ClassCompilerInterfaceTest extends TestCase
{
    public function testConstructWillAcceptAnInterface()
    {
        $compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock4');
        $this->assert($compiler->generateCode(), is_not_blank);
    }
}
