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

	public function comparisons()
	{
		return array(
			'string does not start with another string' => array('"abc" does not end with "a"'),
			'needle longer than haystack'               => array('"abc" does not end with "abcd"'),
		);
	}

	/**
	 * @dataProvider comparisons
	 */
	public function testComparisons($assert)
	{
		$this->assert($assert);
	}
}
