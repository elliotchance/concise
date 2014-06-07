<?php

namespace Concise;

class TestCaseFixtureTest extends TestCase
{
	protected static $fixtureLog = array();

	protected function addFixtureLog($method)
	{
		self::$fixtureLog[] = "$method " . $this->getName();
	}

	public function setUp()
	{
		parent::setUp();
		$this->addFixtureLog('setUp');
	}

	public function prepare()
	{
		parent::prepare();
		$this->addFixtureLog('prepare');
	}

	public function tearDown()
	{
		parent::tearDown();
		$this->addFixtureLog('tearDown');
	}

	public function finalize()
	{
		parent::finalize();
		$this->addFixtureLog('finalize');
	}

	public function _test_1_equals_1()
	{
	}

	public function testNothing()
	{
		$this->assertTrue(true);
	}

	public function _test_a_few_things()
	{
		return array(
			'1 equals 1',
			'2 equals 2',
			'3 equals 3'
		);
	}

	protected function onNotSuccessfulTest(\Exception $e)
    {
    	$this->assertEquals('2 equals 3', $e->getMessage());
    }

	public static function tearDownAfterClass()
	{
		$expected = array(
			'prepare ',
            'setUp ',
            'prepare ',
            'setUp ',
			'prepare testNothing',
            'setUp testNothing',
            'finalize testNothing',
            'tearDown testNothing',
            'setUp test with data set "_test_1_equals_1: 1 equals 1"',
            'prepare test with data set "_test_1_equals_1: 1 equals 1"',
            'finalize test with data set "_test_1_equals_1: 1 equals 1"',
            'tearDown test with data set "_test_1_equals_1: 1 equals 1"',
            'setUp test with data set "_test_a_few_things: 1 equals 1"',
            'prepare test with data set "_test_a_few_things: 1 equals 1"',
            'tearDown test with data set "_test_a_few_things: 1 equals 1"',
            'setUp test with data set "_test_a_few_things: 2 equals 2"',
            'tearDown test with data set "_test_a_few_things: 2 equals 2"',
            'setUp test with data set "_test_a_few_things: 3 equals 3"',
            'finalize test with data set "_test_a_few_things: 3 equals 3"',
            'tearDown test with data set "_test_a_few_things: 3 equals 3"',
		);
		if(self::$fixtureLog !== $expected) {
			var_dump(self::$fixtureLog, $expected);
			throw new \Exception("Fixture log did not pass.");
		}
	}
}
