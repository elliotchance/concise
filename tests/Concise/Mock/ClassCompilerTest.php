<?php

namespace Concise\Mock;

use Concise\Core\TestCase;

class ClassCompilerMock1
{
}

abstract class ClassCompilerMock2
{
    abstract public function myMethod();
}

class ClassCompilerTest extends TestCase
{
    public function testClassNameIsUsedInTheNamingOfTheMockClass()
    {
        $compiler = new ClassCompiler('DateTime');
        $this->assertPHP(
            $compiler,
            "class DateTime_% extends \\DateTime implements % {%}"
        );
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage The class 'DoesntExist' is not loaded so it
     *     cannot be mocked.
     */
    public function testExceptionIsThrownIfClassToBeMockedIsNotLoaded()
    {
        new ClassCompiler('DoesntExist');
    }

    public function testMockedClassesWillBePutIntoTheCorrectNamespace()
    {
        $compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock1');
        $this->assertPHP(
            $compiler,
            "namespace Concise\Mock; class ClassCompilerMock1_% extends \Concise\Mock\ClassCompilerMock1 implements % {%}"
        );
    }

    public function testInstanceCanBeReturnedFromGeneratedCode()
    {
        $compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock1');
        $this->assert($compiler->newInstance())
            ->instanceOf('Concise\Mock\ClassCompilerMock1');
    }

    public function testCanGenerateMockFromAbstractClass()
    {
        $compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock2');
        $this->assert($compiler->newInstance())
            ->instanceOf('Concise\Mock\ClassCompilerMock2');
    }

    public function testMultipleMocksGeneratedFromTheSameClassIsPossible()
    {
        $a = new ClassCompiler('Concise\Mock\ClassCompilerMock1');
        $b = new ClassCompiler('Concise\Mock\ClassCompilerMock1');
        $this->assert($a->newInstance())
            ->doesNotExactlyEqual($b->newInstance());
    }

    /**
     * @param string $php
     */
    protected function assertPHP(ClassCompiler $compiler, $php)
    {
        $this->assertString($compiler->generateCode())
            ->matches('/' . str_replace('%', '(.*)', preg_quote($php)) . '/sm');
        $compiler->newInstance();
    }

    public function testExtraBackslashesAtTheStartOfTheClassNameWillBeTrimmedOff(
    )
    {
        $compiler = new ClassCompiler('\Concise\Mock\ClassCompilerMock2');
        $this->assert($compiler->newInstance())
            ->instanceOf('Concise\Mock\ClassCompilerMock2');
    }

    public function testTheNameOfTheClassCanBeSet()
    {
        $compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock1');
        $compiler->setCustomClassName('MyCustomClass');
        $this->assert(get_class($compiler->newInstance()))
            ->equals('Concise\Mock\MyCustomClass');
    }

    public function testTheClassCanBeCreatedInADifferentNamespace()
    {
        $compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock1');
        $compiler->setCustomClassName('Other\Place\MyRandomClass');
        $this->assert(get_class($compiler->newInstance()))
            ->equals('Other\Place\MyRandomClass');
    }

    public function testTheClassCanBeMovedIntoTheGlobalNamespace()
    {
        $compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock1');
        $compiler->setCustomClassName('\MyCustomClass');
        $this->assert(get_class($compiler->newInstance()))
            ->equals('MyCustomClass');
    }

    public function testWillIgnorePreceedingBackslashForCustomClassName()
    {
        $compiler = new ClassCompiler('\Concise\Mock\ClassCompilerMock2');
        $compiler->setCustomClassName('\Concise\Mock\ClassCompilerMock2Foo');
        $this->assert($compiler->newInstance())
            ->instanceOf('Concise\Mock\ClassCompilerMock2');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage You cannot use 'DateTime' because a class with
     *     that name already exists.
     */
    public function testCustomClassNameCannotBeUsedIfTheClassAlreadyExists()
    {
        $compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock1');
        $compiler->setCustomClassName('\DateTime');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testClassNameMustBeAString()
    {
        new ClassCompiler(123);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected bool, but got string for argument 2
     */
    public function testNiceMockMustBeABoolean()
    {
        new ClassCompiler('Concise\Mock\ClassCompilerMock1', '123');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected boolean, but got integer for argument
     *     4
     */
    public function testDisableConstructorMustBeABoolean()
    {
        new ClassCompiler(
            'Concise\Mock\ClassCompilerMock1', false, array(), 123
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testSetCustomClassNameMustBeAString()
    {
        $compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock1');
        $compiler->setCustomClassName(123);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testExposeMethodMustBeAString()
    {
        $compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock1');
        $compiler->addExpose(123);
    }
}
