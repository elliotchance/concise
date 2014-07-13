<?php

namespace Concise\Matcher;

class HasValuesTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new HasKeys();
	}

	public function testArrayHasOneValue()
	{
		$this->assert('[123] has values [123]');
	}

	public function testArrayDoesNotContainAllValues()
	{
		$this->assertFailure('[123] has values [0,123]');
	}
}
