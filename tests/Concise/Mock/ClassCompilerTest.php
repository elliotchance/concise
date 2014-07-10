<?php

namespace Concise\Mock;

use \Concise\TestCase;

class ClassCompilerMock1
{
}

class ClassCompilerTest extends TestCase
{
	public function testPHPCodeIsGeneratedWithTheClassName()
	{
		$compiler = new ClassCompiler('DateTime');
		$this->assert($compiler->generateCode(), equals, "class DateTimeMock extends DateTime {}");
	}

	public function testClassNameIsUsedInTheNamingOfTheMockClass()
	{
		$compiler = new ClassCompiler('ReflectionClass');
		$this->assert($compiler->generateCode(), equals, "class ReflectionClassMock extends ReflectionClass {}");
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
		$this->assert($compiler->generateCode(), equals, "namespace Concise\Mock; class ClassCompilerMock1Mock extends ClassCompilerMock1 {}");
	}
}
