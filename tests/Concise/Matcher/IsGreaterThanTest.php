<?php

namespace Concise\Matcher;

class IsGreaterThanTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsGreaterThan();
	}

	public function testLessThan()
	{
		$this->assertFailure(100, is_greater_than, 200);
	}

	public function testGreaterThanOrEqual()
	{
		$this->assertFailure(200, is_greater_than, 200);
	}

	public function testGreaterThan()
	{
		$this->assert(300, is_greater_than, 200);
	}
}
