<?php

namespace Concise\Matcher;

class HasKeyTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new HasKey();
	}

	public function testArrayIntegerHasKey()
	{
		$this->assert('[123] has key 0');
	}
}
