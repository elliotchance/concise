<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class StringStartsWithTest extends AbstractMatcherTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new StringStartsWith();
	}

	public function _test_comparisons()
	{
		return array(
			'number substring'                          => '123 starts with 12',
			'basic string'                              => '"abc" starts with "ab"',
			'strings are equal'                         => '"abc" starts with "abc"',
		);
	}
}
