<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsAnArrayTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsAnArray();
	}

	public function _test_x_is_an_array()
	{
		$this->x = array();
	}

	public function _test_x_is_not_an_array()
	{
		$this->x = 123;
	}
}
