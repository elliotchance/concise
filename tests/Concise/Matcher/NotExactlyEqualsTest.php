<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class NotExactlyEqualsTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new NotExactlyEquals();
	}

	public function comparisons()
	{
		return array(
			array('123 is not exactly equal to 123.0'),
			array('123 is not exactly equal to "123"'),
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
