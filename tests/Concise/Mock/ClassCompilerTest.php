<?php

namespace Concise\Mock;

use \Concise\TestCase;

class ClassCompilerMock1
{
}

abstract class ClassCompilerMock2
{
	public abstract function myMethod();
}

class ClassCompilerTest extends TestCase
{
	public function testClassNameIsUsedInTheNamingOfTheMockClass()
	{
		$compiler = new ClassCompiler('DateTime');
		$this->assertPHP($compiler, "class DateTime_% extends \\DateTime {%}");
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage The class 'DoesntExist' is not loaded so it cannot be mocked.
	 */
	public function testExceptionIsThrownIfClassToBeMockedIsNotLoaded()
	{
		new ClassCompiler('DoesntExist');
	}

	public function testMockedClassesWillBePutIntoTheCorrectNamespace()
	{
		$compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock1');
		$this->assertPHP($compiler, "namespace Concise\Mock; class ClassCompilerMock1_% extends \Concise\Mock\ClassCompilerMock1 {%}");
	}

	public function testInstanceCanBeReturnedFromGeneratedCode()
	{
		$compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock1');
		$this->assert($compiler->newInstance(), instance_of, 'Concise\Mock\ClassCompilerMock1');
	}

	public function testCanGenerateMockFromAbstractClass()
	{
		$compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock2');
		$this->assert($compiler->newInstance(), instance_of, 'Concise\Mock\ClassCompilerMock2');
	}

	public function testMultipleMocksGeneratedFromTheSameClassIsPossible()
	{
		$a = new ClassCompiler('Concise\Mock\ClassCompilerMock1');
		$b = new ClassCompiler('Concise\Mock\ClassCompilerMock1');
		$this->assert($a->newInstance(), is_not_exactly_equal_to, $b->newInstance());
	}

	/**
	 * @param string $php
	 */
	protected function assertPHP(ClassCompiler $compiler, $php)
	{
		$this->assert($compiler->generateCode(), matches_regex, '/' . str_replace('%', '(.*)', preg_quote($php)) . '/');
		$compiler->newInstance();
	}

	public function testExtraBackslashesAtTheStartOfTheClassNameWillBeTrimmedOff()
	{
		$compiler = new ClassCompiler('\Concise\Mock\ClassCompilerMock2');
		$this->assert($compiler->newInstance(), instance_of, 'Concise\Mock\ClassCompilerMock2');
	}

	public function testTheNameOfTheClassCanBeSet()
	{
		$compiler = new ClassCompiler('Concise\Mock\ClassCompilerMock1');
		$compiler->setCustomClassName('MyCustomClass');
		$this->assert(get_class($compiler->newInstance()), equals, 'Concise\Mock\MyCustomClass');
	}
}
