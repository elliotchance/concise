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

	public function comparisons()
	{
		return array(
			'number substring'  => array('123 starts with 12'),
			'basic string'      => array('"abc" starts with "ab"'),
			'strings are equal' => array('"abc" starts with "abc"'),
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
