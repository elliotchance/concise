<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockBuilderFailuresTest extends TestCase
{
	protected static $failures = array();

	protected static $expectedFailures = array(
		'testFailedToFulfilExpectationWillThrowException' => 'Expected myMethod() to be called, but it was not.',
		'testMethodCalledWithWrongArgumentValues' => 'Expected myMethod("foo") to be called, but it was not.',
		'testMissingSecondWithExpectation' => 'Expected myMethod("foo") to be called, but it was not.',
		'testExpectationsRenderMultipleArguments' => 'Expected myMethod("foo", "bar") to be called, but it was not.',
		'testMissingAllExpectations' => 'Expected myMethod("foo") to be called, but it was not.',
		'testLessTimesThanExpected' => 'Expected myMethod("foo") to be called 2 times, but it was called 1 times.',
		'testMoreTimesThanExpected' => 'Expected myMethod("foo") to be called 2 times, but it was called 3 times.',
		'testExpectionThatIsNeverCalledWillFail' => 'Expected myMethod("foo") to be called, but it was not.',
		'testExpectionMustBeCalledTheRequiredAmountOfTimes' => 'Expected myMethod("foo") to be called 2 times, but it was called 1 times.',
	);

	public function testFailedToFulfilExpectationWillThrowException()
	{
		$this->mock('\Concise\Mock\Mock1')
		     ->expect('myMethod')
		     ->done();
	}

	public function testMethodCalledWithWrongArgumentValues()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->expect('myMethod')->with('foo')
		                   ->done();
		$this->mock->myMethod('bar');
	}

	public function testMissingSecondWithExpectation()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->expect('myMethod')->with('foo')->with('bar')
		                   ->done();
		$this->mock->myMethod('bar');
	}

	public function testExpectationsRenderMultipleArguments()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->expect('myMethod')->with('foo', 'bar')
		                   ->done();
		$this->mock->myMethod('bar');
	}

	public function testMissingAllExpectations()
	{
		$this->mock('\Concise\Mock\Mock1')
		     ->expect('myMethod')->with('foo')->with('bar')
		     ->done();
	}

	public function testLessTimesThanExpected()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->expect('myMethod')->with('foo')->twice()
		                                       ->with('bar')
		                   ->done();
		$this->mock->myMethod('foo');
	}

	public function testExpectionThatIsNeverCalledWillFail()
	{
		$this->mock('\Concise\Mock\Mock1')
		     ->expect('myMethod')->with('foo')->andReturn('bar')
		     ->done();
	}

	public function testExpectionMustBeCalledTheRequiredAmountOfTimes()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->expect('myMethod')->with('foo')->twice()->andReturn('bar')
		                   ->done();
		$this->mock->myMethod('foo');
	}

	public function testMoreTimesThanExpected()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->expect('myMethod')->with('foo')->twice()
		                                       ->with('bar')
		                   ->done();
		$this->mock->myMethod('foo');
		$this->mock->myMethod('foo');
		$this->mock->myMethod('foo');
	}

	protected function onNotSuccessfulTest(\Exception $e)
	{
		self::$failures[] = $this->getName();
		$this->assert(self::$expectedFailures[$this->getName()], equals, $e->getMessage());
	}

	public static function tearDownAfterClass()
	{
		$a = array_keys(self::$expectedFailures);
		$b = self::$failures;
		assert_that(array_diff($a, $b), equals, array_diff($b, $a));
	}
}
