<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockExpose
{
	protected function myMethod()
	{
		return 'abc';
	}
}

class MockBuilderExposeTest extends TestCase
{
	public function testExposeWillReturnSelfToAllowChaining()
	{
		$builder = $this->mock('\Concise\Mock\MockExpose');
		$this->assert($builder, equals, $builder->expose('myMethod'));
	}

	public function testExposeASingleMethod()
	{
		$mock = $this->niceMock('\Concise\Mock\MockExpose')
		             ->expose('myMethod')
		             ->done();
		$this->assert($mock->myMethod(), equals, 'abc');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Method 'Concise\Mock\MockExpose::foo' does not exist.
	 */
	public function testAnExceptionIsThrownIfTheMethodDoesNotExist()
	{
		$this->niceMock('\Concise\Mock\MockExpose')
		     ->expose('foo')
		     ->done();
	}
}
