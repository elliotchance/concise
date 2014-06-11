<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsAnArrayTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsAnArray();
	}

	public function testIsAnArray()
	{
		$this->x = array();
		$this->assert('x is an array');
	}
}
