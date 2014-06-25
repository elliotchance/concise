<?php

namespace Concise\Matcher;

class HasValueTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new HasValue();
	}

	public function testArrayValueExists()
	{
		$this->assert('[123] has value 123');
	}

	public function testArrayValueDoesNotExist()
	{
		$this->assertFailure('["abc"] contains "def"');
	}
}
