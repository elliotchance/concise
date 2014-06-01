<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsAStringTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsAString();
	}

	public function _test_comparisons()
	{
		return array(
			'"123" is a string',
		);
	}
}
