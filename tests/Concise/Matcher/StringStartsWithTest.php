<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class StringStartsWithTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new StringStartsWith();
	}

	public function _test_comparisons()
	{
		return array(
			'123 starts with 12',
			'123 starts with "12"',
			'"123" starts with 12',
			'"abc" starts with "ab"',
			'"abc" starts with "abc"',
			'"abc" does not start with "c"',
			'"abc" does not start with "abcd"'
		);
	}
}
