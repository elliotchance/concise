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
		$mock = $this->mock('\Concise\TestCase')
		             ->done();
		$this->assert($mock, 'instance of \Concise\TestCase');
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
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->stub(array('myMethod' => 123))
		             ->done();
		$this->assertSame(123, $mock->myMethod());
	}

	public function testStubbingWithAnArrayCanCreateMultipleStubs()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->stub(array('myMethod' => 123, 'foo' => 'bar'))
		             ->done();
		$this->assertSame('bar', $mock->foo());
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
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->done();
		$mock->myMethod();
	}

	public function testNiceMockCanBeCreatedFromAClassThatExists()
	{
		$mock = $this->niceMock('\Concise\TestCase')
		             ->done();
		$this->assert($mock, 'instance of \Concise\TestCase');
	}

	public function testCallingMethodThatHasNoAssociatedActionOnANiceMockWillUseOriginal()
	{
		$mock = $this->niceMock('\Concise\Mock\Mock1')
		             ->done();
		$this->assertSame('abc', $mock->myMethod());
	}

	public function testCallingMethodOnNiceMockWithStub()
	{
		$mock = $this->niceMock('\Concise\Mock\Mock1')
		             ->stub(array('myMethod' => 123))
		             ->done();
		$this->assertSame(123, $mock->myMethod());
	}

	public function testStubsCanBeCreatedByChainingAnAction()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->stub('myMethod')->andReturn(123)
		             ->done();
		$this->assertSame(123, $mock->myMethod());
	}

	public function testStubWithNoActionWillReturnNull()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->stub('myMethod')
		                   ->done();
		$this->assertNull($this->mock->myMethod());
	}

	public function testStubCanReturnNull()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->stub('myMethod')->andReturn(null)
		             ->done();
		$this->assertNull($mock->myMethod());
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage whatever
	 */
	public function testStubCanThrowException()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->stub('myMethod')->andThrow(new \Exception('whatever'))
		             ->done();
		$mock->myMethod();
	}

	public function testCanCreateAnExpectation()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->expect('myMethod')->once()->andReturn(null)
		             ->done();
		$mock->myMethod();
	}

	public function testCanCreateAnExpectationOfTwice()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->expect('myMethod')->twice()->andReturn(null)
		             ->done();
		$mock->myMethod();
		$mock->myMethod();
	}

	public function testCanCreateAnExpectationOfNever()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->expect('myMethod')->never()->andReturn(null)
		             ->done();
	}

	public function testWeDoNotNeedToSpecifyAnActionForAnExpectationWeNeverWantToHappen()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->expect('myMethod')->never()
		             ->done();
	}

	public function testCanCreateAnExpectationOfASpecificAmountOfTimes()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->expect('myMethod')->exactly(3)->andReturn(null)
		             ->done();
		$mock->myMethod();
		$mock->myMethod();
		$mock->myMethod();
	}

	public function testExactlyZeroIsTheSameAsNever()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->expect('myMethod')->exactly(0)
		             ->done();
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage myMethod() has more than one action attached.
	 */
	public function testMethodsCanOnlyHaveOneActionAppliedToThem()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->stub('myMethod')->andReturn(123)->andReturn(456)
		             ->done();
	}

	public function testDefaultExpectationIsOnce()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->expect('myMethod')->andReturn(null)
		             ->done();
		$mock->myMethod();
	}

	public function testCanCreateAnExpectationWithArgumentValues()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->expect('myMethod')->with('foo')->andReturn('bar')
		             ->done();
		$this->assertSame('bar', $mock->myMethod('foo'));
	}

	public function testCanUseExpectsInsteadOfExpect()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->expects('myMethod')
		             ->done();
		$mock->myMethod();
	}

	public function testMockClassDefaultsToStdClass()
	{
		$mock = $this->mock()
		             ->done();
		$this->assert($mock, 'instance of \stdClass');
	}

	public function testNiceMockClassDefaultsToStdClass()
	{
		$mock = $this->niceMock()
		             ->done();
		$this->assert($mock, 'instance of \stdClass');
	}
}
