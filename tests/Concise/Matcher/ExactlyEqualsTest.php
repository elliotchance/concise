<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class ExactlyEqualsTest extends AbstractMatcherTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new ExactlyEquals();
	}

	public function _test_comparisons()
	{
		return array(
			'123 exactly equals 123',
		);
	}
}
