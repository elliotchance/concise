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
}
