<?php

namespace Concise\Matcher;

class IsNotAnArrayTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsNotAnArray();
	}

	public function testComparison()
	{
		$this->x = 123;
		$this->assert('x is not an array');
	}
}
