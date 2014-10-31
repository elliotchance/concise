<?php

namespace Concise\Mock;

use \Concise\TestCase;

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

    public function testWillImplementAnInterface()
    {
        $compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock4');
        $this->assert($compiler->newInstance(), instance_of, 'Concise\Mock\ClassCompilerMock4');
    }
}
