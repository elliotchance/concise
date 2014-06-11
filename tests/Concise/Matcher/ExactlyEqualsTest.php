<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class ExactlyEqualsTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new ExactlyEquals();
	}

	public function _test_comparisons()
	{
		return array(
			'123 exactly equals 123',
		);
	}
}
