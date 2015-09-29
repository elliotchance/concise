<?php

namespace Concise\Mock;

use Concise\Core\TestCase;

interface ClassCompilerMock4
{
}

class ClassCompilerInterfaceTest extends TestCase
{
    public function testConstructWillAcceptAnInterface()
    {
        $compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock4');
        $this->assertString($compiler->generateCode())->isNotEmpty;
    }

    public function testWillImplementAnInterface()
    {
        $compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock4');
        $this->assert($compiler->newInstance())
            ->instanceOf('Concise\Mock\ClassCompilerMock4');
    }
}
