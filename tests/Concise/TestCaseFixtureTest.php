<?php

namespace Concise;

class TestCaseFixtureTest extends TestCase
{
	protected static $setUpCount = 0;

	public function setUp()
	{
		parent::setUp();
		++self::$setUpCount;
	}

	public function _test_1_equals_1()
	{
		// +1 for setUp
	}

	public function testNothing()
	{
		// +1 for setUp
		$this->assertTrue(true);
	}

	public function _test_a_few_things()
	{
		// +3 for setUp
		return array(
			'1 equals 1',
			'2 equals 2',
			'3 equals 3'
		);
	}

	public static function tearDownAfterClass()
	{
		$expectedSetUpCount = 5;
		if(self::$setUpCount !== $expectedSetUpCount) {
			throw new \Exception("Expected setUpCount to be $expectedSetUpCount, but was " . self::$setUpCount);
		}
	}
}
