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

class MockBuilderConstructorTest extends TestCase
{
	public function testMocksWillCallConstructorByDefault()
	{
		$mock = $this->mock('\Concise\Mock\MockConstructor1')
		             ->done();
		$this->assert($mock->constructorRun);
	}
}
