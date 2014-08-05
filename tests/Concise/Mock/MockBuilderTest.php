<?php

namespace Concise\Mock;

use \Concise\TestCase;

abstract class Mock2
{
	public abstract function foo();

	public function bar()
	{
		return 123;
	}
}

class MockBuilderTest extends TestCase
{
	public function testMockCanBeCreatedFromAClassThatExists()
	{
		$mock = $this->mock('\Concise\TestCase')
		             ->done();
		$this->assert($mock, instance_of, '\Concise\TestCase');
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Class '\Abc' does not exist.
	 */
	public function testExceptionIsThrownIfTheClassTryingToBeMockedDoesNotExist()
	{
		$this->mock('\Abc')->done();
	}

	// @test you cannot mock methods that do not exist

	// @test you can only mock methods that do not exist if there is an approproate __call

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage myMethod() does not have an associated action - consider a niceMock()?
	 */
	public function testCallingMethodThatHasNoAssociatedActionWillThrowAnException()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->done();
		$mock->myMethod();
	}

	public function testNiceMockCanBeCreatedFromAClassThatExists()
	{
		$mock = $this->niceMock('\Concise\TestCase')
		             ->done();
		$this->assert($mock, instance_of, '\Concise\TestCase');
	}

	public function testCallingMethodThatHasNoAssociatedActionOnANiceMockWillUseOriginal()
	{
		$mock = $this->niceMock('\Concise\Mock\Mock1')
		             ->done();
		$this->assert($mock->myMethod(), equals, 'abc');
	}

	public function testMockClassDefaultsToStdClass()
	{
		$mock = $this->mock()
		             ->done();
		$this->assert($mock, instance_of, '\stdClass');
	}

	public function testNiceMockClassDefaultsToStdClass()
	{
		$mock = $this->niceMock()
		             ->done();
		$this->assert($mock, instance_of, '\stdClass');
	}
}
