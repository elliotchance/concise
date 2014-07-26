<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockConstructor1
{
	public $constructorRun = false;

	public function __construct()
	{
		$this->constructorRun = true;
	}
}

class MockConstructor2
{
	public function __construct($abc)
	{
	}
}

class MockBuilderConstructorTest extends TestCase
{
	public function testMocksWillCallConstructorByDefault()
	{
		$mock = $this->mock('\Concise\Mock\MockConstructor1')
		             ->done();
		$this->assert($mock->constructorRun);
	}

	public function testDisableConstructorCanBeChained()
	{
		$mock = $this->mock('\Concise\Mock\MockConstructor1')
		             ->disableConstructor()
		             ->done();
		$this->assert($mock, instance_of, '\Concise\Mock\MockConstructor1');
	}

	public function testMocksCanHaveTheirConstructorDisabled()
	{
		$mock = $this->mock('\Concise\Mock\MockConstructor1')
		             ->disableConstructor()
		             ->done();
		$this->assert($mock->constructorRun, is_false);
	}

	public function testMocksCanHaveTheirConstructorDisabledWithArguments()
	{
		$mock = $this->mock('\Concise\Mock\MockConstructor2')
		             ->disableConstructor()
		             ->done();
		$this->assert($mock, instance_of, '\Concise\Mock\MockConstructor2');
	}
}
