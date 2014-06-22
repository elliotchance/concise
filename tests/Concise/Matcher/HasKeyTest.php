<?php

namespace Concise\Matcher;

class HasKeyTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new HasKey();
	}

	public function testArrayHasIntegerKey()
	{
		$this->assert('[123] has key 0');
	}

	public function testKeyDoesNotExist()
	{
		$this->assertFailure('[123] has key 1');
	}

	public function testArrayHasStringKey()
	{
		$this->assert('["abc":123] has key "abc"');
	}
}
