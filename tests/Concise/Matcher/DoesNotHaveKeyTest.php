<?php

namespace Concise\Matcher;

class DoesNotHaveKeyTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new DoesNotHaveKey();
	}

	public function testArrayHasIntegerKey()
	{
		$this->assertFailure('[123] does not have key 0');
	}

	public function testKeyDoesNotExist()
	{
		$this->assert('[123] does not have key 1');
	}

	public function testArrayHasStringKey()
	{
		$this->assertFailure('["abc":123] does not have key "abc"');
	}
}
