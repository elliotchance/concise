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

	public function testIsNotAnObjectFailure()
	{
		$this->assert('123 is not an object');
	}
}
