<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockBuilderFailuresTest extends TestCase
{
	protected static $failures = array();

	protected static $expectedFailures = array(
		'testFailedToFulfilExpectationWillThrowException' => 'Expected myMethod() to be called, but it was not.',
		'testMethodCalledWithWrongArgumentValues' => 'Expected myMethod("foo") to be called, but it was not.',
		'testMissingSecondWithExpectation' => 'Expected myMethod("foo") to be called, but it was not.'
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
