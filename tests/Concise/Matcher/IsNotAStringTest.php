<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsNotAStringTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsNotAString();
	}

	public function _test_comparisons()
	{
		return array(
			'123 is not a string',
		);
	}
}
