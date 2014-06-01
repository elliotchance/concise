<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class StringDoesNotStartWithTest extends AbstractMatcherTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new StringDoesNotStartWith();
	}

	public function _test_comparisons()
	{
		return array(
			'string does not start with another string' => '"abc" does not start with "c"',
			'needle longer than haystack'               => '"abc" does not start with "abcd"',
		);
	}
}
