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

	public function _test_comparisons()
	{
		$this->x = null;
		$this->y = 'a';
		return array(
			'y is not null',
			'"null" is not null',
			'"" is not null',
		);
	}
}
