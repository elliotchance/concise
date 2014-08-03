<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockBuilderFailuresTest extends TestCase
{
	protected static $failures = array();

	protected static $expectedFailures = array(
		'testFailedToFulfilExpectationWillThrowException' => "0 equals 1",
		'testMethodCalledWithWrongArgumentValues' => '["bar"] exactly equals ["foo"]',
		'testExpectionThatIsNeverCalledWillFail' => 'Expected myMethod() to be called.',
		'testExpectionMustBeCalledTheRequiredAmountOfTimes' => 'Expected myMethod() to be called 2 times, but was only called 1 times.',
	);

	public function testFailedToFulfilExpectationWillThrowException()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->expect('myMethod')->andReturn(null)
		                   ->done();
	}

	public function testMethodCalledWithWrongArgumentValues()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->expect('myMethod')->with('foo')->andReturn(null)
		                   ->done();
		$this->mock->myMethod('bar');
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
		                   ->expect('myMethod')->twice()->with('foo')->andReturn('bar')
		                   ->done();
		$this->mock->myMethod('foo');
	}

	protected function onNotSuccessfulTest(\Exception $e)
	{
		self::$failures[] = $this->getName();
		$this->assert(self::$expectedFailures[$this->getName()], equals, $e->getMessage());
	}

	public static function tearDownAfterClass()
	{
		if(count(self::$failures) !== count(self::$expectedFailures)) {
			throw new \Exception("All tests must fail, but only " . implode(", ", self::$failures) . " did.");
		}
	}
}
