<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class NotExactlyEqualsTest extends AbstractMatcherTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new NotExactlyEquals();
	}

	public function _test_comparisons()
	{
		return array(
			'123 is not exactly equal to 123.0',
			'123 is not exactly equal to "123"',
		);
	}
}
