<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class StringEndsWithTest extends AbstractMatcherTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new StringEndsWith();
	}

	public function _test_comparisons()
	{
		return array(
			'number substring'  => '123 ends with 23',
			'basic string'      => '"abc" ends with "bc"',
			'strings are equal' => '"abc" ends with "abc"',
		);
	}
}
