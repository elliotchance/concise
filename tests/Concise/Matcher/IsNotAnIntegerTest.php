<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsNotAnIntegerTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsNotAnInteger();
	}

	public function _test_is_not_an_integer()
	{
		return array(
			'"123" is not an integer',
			'1.23 is not an integer',
		);
	}
}
