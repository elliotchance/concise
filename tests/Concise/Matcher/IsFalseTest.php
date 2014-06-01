<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsFalseTest extends AbstractMatcherTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new IsFalse();
	}

	public function _test_comparisons()
	{
		return array(
			'`false` is false'
		);
	}
}
