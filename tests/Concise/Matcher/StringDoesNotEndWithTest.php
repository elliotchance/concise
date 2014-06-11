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

	public function _test_comparisons()
	{
		return array(
			'string does not start with another string' => '"abc" does not end with "a"',
			'needle longer than haystack'               => '"abc" does not end with "abcd"',
		);
	}
}
