<?php

namespace Concise\Mock;

use \Concise\TestCase;
use \Concise\Mock\Action\ReturnValueAction;

class ClassCompilerMock1
{
}

abstract class ClassCompilerMock2
{
	public abstract function myMethod();
}

class ClassCompilerMock3
{
	protected function hidden()
	{
		return 'foo';
	}
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

	public function testAMethodCanBeExposed()
	{
		$compiler = new ClassCompiler('\Concise\Mock\ClassCompilerMock3', true);
		$compiler->addExpose('hidden');
		$instance = $compiler->newInstance();
		$this->assert($instance->hidden(), equals, 'foo');
	}

	public function testAMethodThatHasARuleCanBeExposed()
	{
		$compiler = new ClassCompiler('\Concise\Mock\ClassCompilerMock3', true);
		$compiler->setRules(array('hidden' => array('action' => new ReturnValueAction('bar'))));
		$compiler->addExpose('hidden');
		$instance = $compiler->newInstance();
		$this->assert($instance->hidden(), equals, 'bar');
	}
}
