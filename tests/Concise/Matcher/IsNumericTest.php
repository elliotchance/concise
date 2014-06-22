<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsNumericTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsNumeric();
	}

	public function testIntegerIsNumeric()
	{
		$this->assert('123 is numeric');
	}
}
