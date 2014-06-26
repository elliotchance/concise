<?php

namespace Concise\Mock;

use \Concise\TestCase;

class Mock1
{
	public function myMethod()
	{
		return 'abc';
	}
}

class MockBuilderTest extends TestCase
{
	protected function mock($className)
	{
		return new MockBuilder($this, $className);
	}

	public function testMockCanBeCreatedFromAClassThatExists()
	{
		$this->mock = $this->mock('\Concise\TestCase')
		                   ->done();
		$this->assert('mock instance of \Concise\TestCase');
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Class '\Abc' does not exist.
	 */
	public function testExceptionIsThrownIfTheClassTryingToBeMockedDoesNotExist()
	{
		$this->mock('\Abc')->done();
	}

	public function testCanStubMethodWithAssociativeArray()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->stub(array('myMethod' => 123))
		                   ->done();
		$this->assertSame(123, $this->mock->myMethod());
	}

	public function testStubbingWithAnArrayCanCreateMultipleStubs()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->stub(array('myMethod' => 123, 'foo' => 'bar'))
		                   ->done();
		$this->assertSame('bar', $this->mock->foo());
	}
}
