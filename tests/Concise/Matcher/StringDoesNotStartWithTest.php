<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class StringDoesNotStartWithTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new StringDoesNotStartWith();
	}

	public function comparisons()
	{
		return array(
			'string does not start with another string' => array('"abc" does not start with "c"'),
			'needle longer than haystack'               => array('"abc" does not start with "abcd"'),
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
