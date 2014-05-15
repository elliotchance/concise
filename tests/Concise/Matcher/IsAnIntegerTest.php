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

	public function _test_is_not_an_integer()
	{
		return array(
			'"123" is not an integer',
			'1.23 is not an integer',
		);
	}
}
