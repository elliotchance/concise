<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockBuilderStubTest extends TestCase
{
	public function testCanStubMethodWithAssociativeArray()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->stub(array('myMethod' => 123))
		             ->done();
		$this->assert($mock->myMethod(), equals, 123);
	}

	public function testStubbingWithAnArrayCanCreateMultipleStubs()
	{
		$mock = $this->mock('\Concise\Mock\Mock2')
		             ->stub(array('bar' => 123, 'foo' => 'bar'))
		             ->done();
		$this->assert($mock->foo(), equals, 'bar');
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

	public function testCallingMethodOnNiceMockWithStub()
	{
		$mock = $this->niceMock('\Concise\Mock\Mock1')
		             ->stub(array('myMethod' => 123))
		             ->done();
		$this->assert($mock->myMethod(), equals, 123);
	}

	public function testStubsCanBeCreatedByChainingAnAction()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->stub('myMethod')->andReturn(123)
		             ->done();
		$this->assert($mock->myMethod(), equals, 123);
	}

	public function testStubWithNoActionWillReturnNull()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->stub('myMethod')
		                   ->done();
		$this->assert($this->mock->myMethod(), is_null);
	}

	public function testStubCanReturnNull()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->stub('myMethod')->andReturn(null)
		             ->done();
		$this->assert($mock->myMethod(), is_null);
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

	public function testNiceMockCanBeCreatedFromAnAbstractClass()
	{
		$mock = $this->niceMock('\Concise\Mock\Mock2')
		             ->stub(array('foo' => 'bar'))
		             ->done();
		$this->assert($mock->foo(), equals, 'bar');
	}

	public function testMockSetsActualCallsToZeroWhenRuleIsCreated()
	{
		$this->mock('\Concise\Mock\Mock1')
		     ->stub(array('myMethod' => 123))
		     ->done();

		$mock = end($this->_mocks);
		$this->assert(count($mock['instance']->getCallsForMethod('myMethod')), exactly_equals, 0);
	}

	public function testMockSetsCalledTimesToOneWhenMethodIsCalled()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->stub(array('myMethod' => 123))
		             ->done();

		$mock->myMethod();

		$mock = end($this->_mocks);
		$this->assert(count($mock['instance']->getCallsForMethod('myMethod')), exactly_equals, 1);
	}

	public function testMockSetsCalledTimesIncrementsWithMultipleCalls()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->stub(array('myMethod' => 123))
		             ->done();

		$mock->myMethod();
		$mock->myMethod();

		$mock = end($this->_mocks);
		$this->assert(count($mock['instance']->getCallsForMethod('myMethod')), exactly_equals, 2);
	}
}
