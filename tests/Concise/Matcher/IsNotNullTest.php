<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsNotNullTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsNotNull();
	}

	public function comparisons()
	{
		return array(
			array('y is not null'),
			array('"null" is not null'),
			array('"" is not null'),
		);
	}

	/**
	 * @dataProvider comparisons
	 */
	public function testComparisons($assert)
	{
		$this->x = null;
		$this->y = 'a';
		$this->assert($assert);
	}
}
