<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsNotAnObjectTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsAnObject();
	}

	public function testComparison()
	{
		$this->x = 123;
		$this->assert('x is not an object');
	}
}
