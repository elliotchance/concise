<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockBuilderFailuresTest extends TestCase
{
	protected static $failures = array();

	public function testFailedToFulfilExpectationWillThrowException()
	{
		$this->mock = $this->mock('\Concise\Mock\Mock1')
		                   ->expect('myMethod')->once()->andReturn(null)
		                   ->done();
	}

	protected function onNotSuccessfulTest(\Exception $e)
	{
		self::$failures[] = $this->getName();
	}

	public static function tearDownAfterClass()
	{
		if(count(self::$failures) !== 1) {
			throw new \Exception("All tests must fail, but only " . implode(", ", self::$failures) . " did.");
		}
	}
}
