<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class TrueTest extends AbstractMatcherTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new True();
	}

	public function _test_comparisons()
	{
		return array(
			'true',
		);
	}
}
