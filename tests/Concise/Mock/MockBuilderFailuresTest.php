<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockBuilderFailuresTest extends TestCase
{
	protected static $failures = array();

	protected static $expectedFailures = array(
		'testFailedToFulfilExpectationWillThrowException' => "0 equals 1",
		'testMethodCalledWithWrongArgumentValues' => '["bar"] exactly equals ["foo"]',
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
