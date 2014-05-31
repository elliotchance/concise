<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsAnIntegerTest extends AbstractMatcherTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new IsAnInteger();
	}

	public function _test_x_is_an_integer()
	{
		$this->x = 123;
	}
}
