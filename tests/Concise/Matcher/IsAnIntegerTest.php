<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsAnIntegerTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsAnInteger();
	}

	public function _test_x_is_an_integer()
	{
		$this->x = 123;
	}
}
