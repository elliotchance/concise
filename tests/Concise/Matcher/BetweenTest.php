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

	public function testANumberExistsBetweenTwoOtherNumbers()
	{
		$this->assert(123, between, 100, 'and', 150);
	}

	public function testNumberIsBelowLowerBounds()
	{
		$this->assertFailure(80, between, 100, 'and', 150);
	}
}
