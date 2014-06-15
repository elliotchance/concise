<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class StringDoesNotStartWithTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new StringDoesNotStartWith();
	}
	
	public function testNeedleLongerThanHaystack()
	{
		$this->assert('"abc" does not start with "abcd"');
	}

	public function testStringDoesNotStartWithAnotherString()
	{
		$this->assert('"abc" does not start with "c"');
	}
}
