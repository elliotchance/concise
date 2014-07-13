<?php

namespace Concise\Mock;

use \Concise\TestCase;

abstract class MyClass
{
	public function foo()
	{
	}

	protected abstract function bar();

	protected abstract function baz($a, $b);

	protected abstract function a(\DateTime $a);

	protected abstract function b($a = 123);

	protected abstract function c(&$a);

	protected abstract function d(array $a);

	protected abstract function e(callable $a);

	protected abstract function f($a = array());
}

class PrototypeBuilderTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->builder = new PrototypeBuilder();
	}

	public function testPrototypeIsBuiltFromReflectionMethod()
	{
		$method = new \ReflectionMethod('\Concise\Mock\MyClass', 'foo');
		$this->assert($this->builder->getPrototype($method), equals, 'public function foo()');
	}

	public function testWillRespectPrototypeModifiers()
	{
		$method = new \ReflectionMethod('\Concise\Mock\MyClass', 'bar');
		$this->assert($this->builder->getPrototype($method), equals, 'abstract protected function bar()');
	}

	public function testWillRespectPrototypeArguments()
	{
		$method = new \ReflectionMethod('\Concise\Mock\MyClass', 'baz');
		$this->assert($this->builder->getPrototype($method), equals, 'abstract protected function baz($a, $b)');
	}

	public function testWillNotReturnAbstractKeywordIfToldNotTo()
	{
		$method = new \ReflectionMethod('\Concise\Mock\MyClass', 'bar');
		$this->builder->hideAbstract = true;
		$this->assert($this->builder->getPrototype($method), equals, 'protected function bar()');
	}

	public function testWillRespectPrototypeArgumentTypeHinting()
	{
		$method = new \ReflectionMethod('\Concise\Mock\MyClass', 'a');
		$this->assert($this->builder->getPrototype($method), equals, 'abstract protected function a(\DateTime $a)');
	}

	public function testWillRespectPrototypeArgumentDefaultValue()
	{
		$method = new \ReflectionMethod('\Concise\Mock\MyClass', 'b');
		$this->assert($this->builder->getPrototype($method), equals, 'abstract protected function b($a = 123)');
	}

	public function testWillRespectPrototypeArgumentPassByReference()
	{
		$method = new \ReflectionMethod('\Concise\Mock\MyClass', 'c');
		$this->assert($this->builder->getPrototype($method), equals, 'abstract protected function c(&$a)');
	}

	public function testWillNotSetADefaultValueForInternalMethods()
	{
		$method = new \ReflectionMethod('\DateTime', 'setTime');
		$this->assert($this->builder->getPrototype($method), equals, 'public function setTime($hour, $minute, $second = NULL)');
	}

	public function testArrayHint()
	{
		$method = new \ReflectionMethod('\Concise\Mock\MyClass', 'd');
		$this->assert($this->builder->getPrototype($method), equals, 'abstract protected function d(array $a)');
	}

	public function testCallableHint()
	{
		$method = new \ReflectionMethod('\Concise\Mock\MyClass', 'e');
		$this->assert($this->builder->getPrototype($method), equals, 'abstract protected function e(callable $a)');
	}

	public function testArrayDefaultValue()
	{
		$method = new \ReflectionMethod('\Concise\Mock\MyClass', 'f');
		$this->assert($this->builder->getPrototype($method), equals, "abstract protected function f(\$a = array (\n))");
	}
}
