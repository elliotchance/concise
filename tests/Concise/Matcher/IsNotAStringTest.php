<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsNotAStringTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsNotAString();
	}

	public function testIsNotAString()
	{
		$this->assert('123 is not a string');
	}

	public function testIsNotAStringFailure()
	{
		$this->assertFailure('"123" is not a string');
	}
}
