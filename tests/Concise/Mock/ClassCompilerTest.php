<?php

namespace Concise\Mock;

use \Concise\TestCase;

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
}
