<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsFalseTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsFalse();
	}

	public function _test_comparisons()
	{
		return array(
			'`false` is false'
		);
	}
}
