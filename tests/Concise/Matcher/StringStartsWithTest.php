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

	protected function createStdClassThatCanBeCastToString($value)
	{
		$mock = $this->getMock('\stdClass', array('__toString'));
		$mock->expects($this->any())
		     ->method('__toString')
		     ->will($this->returnValue($value));
		return $mock;
	}

	public function _test_comparisons()
	{
		$this->obj = $this->createStdClassThatCanBeCastToString('foo');
		return array(
			'number substring'                          => '123 starts with 12',
			'basic string'                              => '"abc" starts with "ab"',
			'strings are equal'                         => '"abc" starts with "abc"',
			'string does not start with another string' => '"abc" does not start with "c"',
			'needle longer than haystack'               => '"abc" does not start with "abcd"',
			'objects will be converted to strings'      => 'obj starts with "f"'
		);
	}
}
