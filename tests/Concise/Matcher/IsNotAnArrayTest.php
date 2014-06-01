<?php

namespace Concise\Matcher;

class IsNotAnArrayTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsNotAnArray();
	}

	public function _test_x_is_not_an_array()
	{
		$this->x = 123;
	}
}
