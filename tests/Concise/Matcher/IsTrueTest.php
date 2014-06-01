<?php

namespace Concise\Matcher;

class IsTrueTest extends AbstractMatcherTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new IsTrue();
	}

	public function _test_comparisons()
	{
		return array(
			'`true` is true',
		);
	}
}
