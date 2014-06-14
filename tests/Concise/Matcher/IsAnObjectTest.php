<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsAnObjectTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsAnObject();
	}

	public function testIsAnObject()
	{
		$this->x = new \stdClass();
		$this->assert('x is an object');
	}

	public function testIsAnObjectFailure()
	{
		$this->assertFailure('123 is an object');
	}
}
