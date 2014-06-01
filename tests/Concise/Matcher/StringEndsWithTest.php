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
			'objects will be converted to strings'      => 'obj ends with "oo"'
		);
	}
}
