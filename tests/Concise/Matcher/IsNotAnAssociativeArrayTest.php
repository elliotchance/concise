<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsNotAnAssociativeArrayTest extends AbstractMatcherTestCase
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
		$this->assertFailure('x is not an associative array');
	}

	public function testAnArrayIsAssociativeIfAllIndexesAreIntegersButNotZeroIndexed()
	{
		$this->x = array(
			5 => 123,
			10 => "foo",
		);
		$this->assertFailure('x is not an associative array');
	}

	public function testAnArrayIsNotAssociativeIfZeroIndexed()
	{
		$this->assert('[1,"foo"] is not an associative array');
	}
}
