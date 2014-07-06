<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class BetweenTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new Between();
	}

	public function testNumberExistsBetweenTwoOtherNumbers()
	{
		$this->assert(123, between, 100, 'and', 150);
	}

	public function testNumberIsBelowLowerBounds()
	{
		$this->assertFailure(80, between, 100, 'and', 150);
	}

	public function testNumberIsOnTheLowerBound()
	{
		$this->assert(123, between, 123, 'and', 150);
	}

	public function testNumberIsAboveUpperBounds()
	{
		$this->assertFailure(170, between, 100, 'and', 150);
	}
}
