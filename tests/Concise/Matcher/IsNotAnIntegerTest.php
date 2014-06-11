<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsNotAnIntegerTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsNotAnInteger();
	}

	public function comparisons()
	{
		return array(
			array('"123" is not an integer'),
			array('1.23 is not an integer'),
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
