<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class StringDoesNotEndWithTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new StringDoesNotEndWith();
	}

	public function testNeedleLongerThanHaystack()
	{
		$this->assert('"abc" does not end with "abcd"');
	}

	public function testStringDoesNotStartWithAnotherString()
	{
		$this->assert('"abc" does not end with "a"');
	}
}
