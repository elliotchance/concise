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

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage stub() called with array must have at least 1 element.
	 */
	public function testStubbingWithAnArrayMustHaveMoreThanZeroElements()
	{
		$this->mock('\Concise\Mock\Mock1')
		     ->stub(array())
		     ->done();
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage myMethod() does not have an associated action - consider a niceMock()?
	 */
	public function testCallingMethodThatHasNoAssociatedActionWillThrowAnException()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->done();
		$this->mock->myMethod();
	}

	public function testNiceMockCanBeCreatedFromAClassThatExists()
	{
		$this->mock = $this->niceMock('\Concise\TestCase')
		                   ->done();
		$this->assert('mock instance of \Concise\TestCase');
	}

	public function testCallingMethodThatHasNoAssociatedActionOnANiceMockWillUseOriginal()
	{
		$this->mock = $this->niceMock('\Concise\Mock\Mock1')
		                   ->done();
		$this->assertSame('abc', $this->mock->myMethod());
	}

	public function testCallingMethodOnNiceMockWithStub()
	{
		$this->mock = $this->niceMock('\Concise\Mock\Mock1')
		                   ->stub(array('myMethod' => 123))
		                   ->done();
		$this->assertSame(123, $this->mock->myMethod());
	}

	public function testStubsCanBeCreatedByChainingAnAction()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->stub('myMethod')->andReturn(123)
		                   ->done();
		$this->assertSame(123, $this->mock->myMethod());
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage myMethod() does not have an associated action - did you forget andReturn()?
	 */
	public function testStubWithNoActionThrowsException()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->stub('myMethod')
		                   ->done();
		$this->mock->myMethod();
	}

	public function testStubCanReturnNull()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->stub('myMethod')->andReturn(null)
		                   ->done();
		$this->assertNull($this->mock->myMethod());
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage whatever
	 */
	public function testStubCanThrowException()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->stub('myMethod')->andThrow(new \Exception('whatever'))
		                   ->done();
		$this->mock->myMethod();
	}

	public function testCanCreateAnExpectation()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->expect('myMethod')->once()->andReturn(null)
		                   ->done();
		$this->mock->myMethod();
	}

	public function testCanCreateAnExpectationOfTwice()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->expect('myMethod')->twice()->andReturn(null)
		                   ->done();
		$this->mock->myMethod();
		$this->mock->myMethod();
	}

	public function testCanCreateAnExpectationOfNever()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->expect('myMethod')->never()->andReturn(null)
		                   ->done();
	}

	public function testWeDoNotNeedToSpecifyAnActionForAnExpectationWeNeverWantToHappen()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->expect('myMethod')->never()
		                   ->done();
	}

	public function testCanCreateAnExpectationOfASpecificAmountOfTimes()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->expect('myMethod')->exactly(3)->andReturn(null)
		                   ->done();
		$this->mock->myMethod();
		$this->mock->myMethod();
		$this->mock->myMethod();
	}
}
