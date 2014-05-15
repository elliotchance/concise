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

	public function _test_a_is_an_array()
	{
		$this->a = array();
	}

	public function _test_a_is_not_an_array()
	{
		$this->a = 123;
	}
}
