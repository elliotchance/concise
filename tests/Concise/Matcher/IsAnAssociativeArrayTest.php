<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsAnAssociativeArrayTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsAnAssociativeArray();
	}

	public function testAnAssociativeArrayContainsAtLeastOneKeyThatsNotANumber()
	{
		$this->x = array(
			"a" => 123,
			0 => "foo",
		);
		$this->assert('x is an associative array');
	}

	public function testAnArrayIsAssociativeIfAllIndexesAreIntegersButNotZeroIndexed()
	{
		$this->x = array(
			5 => 123,
			10 => "foo",
		);
		$this->assert('x is an associative array');
	}

	public function testAnArrayIsNotAssociativeIfZeroIndexed()
	{
		$this->assertFailure('[1,"foo"] is an associative array');
	}
}
