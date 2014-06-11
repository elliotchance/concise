<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class NotEqualsTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new NotEquals();
	}

	public function comparisons()
	{
		return array(
			array('123 does not equal 124'),
			array('123 is not equal to 123.1'),
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
