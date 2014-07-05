<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockBuilderFailuresTest extends TestCase
{
	protected static $failures = array();

	protected static $expectedFailures = array(
		'testFailedToFulfilExpectationWillThrowException' => "Expectation failed for method name is equal to <string:myMethod> when invoked 1 time(s).\nMethod was expected to be called 1 times, actually called 0 times.\n",
		'testMethodCalledWithWrongArgumentValues' => "Expectation failed for method name is equal to <string:myMethod> when invoked 1 time(s)\nParameter 0 for invocation Concise\Mock\Mock1::myMethod('bar') does not match expected value.\nFailed asserting that two strings are equal.",
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

	protected function onNotSuccessfulTest(\Exception $e)
	{
		self::$failures[] = $this->getName();
		$this->assert(self::$expectedFailures[$this->getName()], equals, $e->getMessage());
	}

	public static function tearDownAfterClass()
	{
		if(count(self::$failures) !== 2) {
			throw new \Exception("All tests must fail, but only " . implode(", ", self::$failures) . " did.");
		}
	}
}
