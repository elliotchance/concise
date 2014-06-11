<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class EqualsTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new Equals();
	}

	public function comparisons()
	{
		return array(
			array('123 equals 123'),
			array('123 equals 123.0'),
			array('123 equals "123"'),
		);
	}

	/**
	 * @dataProvider comparisons
	 */
	public function testComparisons($assertion)
	{
		$this->assert($assertion);
	}
}
