<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsNullTest extends AbstractMatcherTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new IsNull();
	}

	public function _test_null()
	{
		return '`null` is null';
	}
}
