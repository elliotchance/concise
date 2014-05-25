<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class StringEndsWithTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new StringEndsWith();
	}

	public function _test_comparisons()
	{
		$this->obj = $this->createStdClassThatCanBeCastToString('foo');
		return array(
			'number substring'                          => '123 ends with 23',
			'basic string'                              => '"abc" ends with "bc"',
			'strings are equal'                         => '"abc" ends with "abc"',
			'string does not start with another string' => '"abc" does not end with "a"',
			'needle longer than haystack'               => '"abc" does not end with "abcd"',
			'objects will be converted to strings'      => 'obj ends with "oo"'
		);
	}
}
