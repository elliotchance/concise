<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockBuilderExpectTest extends TestCase
{
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
		$this->assert($mock->myMethod('foo'), equals, 'bar');
	}

	public function testCanUseExpectsInsteadOfExpect()
	{
		$mock = $this->mock('\Concise\Mock\Mock1')
		             ->expects('myMethod')
		             ->done();
		$mock->myMethod();
	}
}
