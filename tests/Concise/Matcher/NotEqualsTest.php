<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class NotEqualsTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new NotEquals();
	}

	public function testNotEquals()
	{
		$this->assert('123 does not equal 124');
	}

	public function testFloatingPointValuesThatDifferSlightlyAreNotEqual()
	{
		$this->assert('123 is not equal to 123.000001');
	}
}
