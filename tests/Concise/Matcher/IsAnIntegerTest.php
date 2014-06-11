<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsAnIntegerTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsAnInteger();
	}

	public function testComparison()
	{
		$this->x = 123;
		$this->assert('x is an integer');
	}
}
