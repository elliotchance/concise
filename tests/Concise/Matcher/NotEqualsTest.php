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

	public function _test_comparisons()
	{
		return array(
			'123 does not equal 124',
			'123 is not equal to 123.1'
		);
	}
}
