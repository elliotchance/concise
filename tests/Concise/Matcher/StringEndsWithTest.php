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

	public function comparisons()
	{
		return array(
			'number substring'  => array('123 ends with 23'),
			'basic string'      => array('"abc" ends with "bc"'),
			'strings are equal' => array('"abc" ends with "abc"'),
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
