<?php

namespace Concise;

class TestCaseFixtureTest extends TestCase
{
	protected static $setUpCount = 0;
	protected static $tearDownCount = 0;

	public function setUp()
	{
		parent::setUp();
		++self::$setUpCount;
	}

	public function tearDown()
	{
		parent::tearDown();
		++self::$tearDownCount;
	}

	public function _test_1_equals_1()
	{
		// +1 for setUp & tearDown
	}

	public function testNothing()
	{
		// +1 for setUp & tearDown
		$this->assertTrue(true);
	}

	public function _test_a_few_things()
	{
		// +3 for setUp & tearDown
		return array(
			'1 equals 1',
			'2 equals 2',
			'3 equals 3'
		);
	}

	public static function tearDownAfterClass()
	{
		$expectedCount = 5;
		if(self::$setUpCount !== $expectedCount) {
			throw new \Exception("Expected setUpCount to be $expectedCount, but was " . self::$setUpCount);
		}
		if(self::$tearDownCount !== $expectedCount) {
			throw new \Exception("Expected tearDownCount to be $expectedCount, but was " . self::$tearDownCount);
		}
	}
}
