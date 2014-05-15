<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsAnObjectTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsAnObject();
	}

	public function _test_x_is_an_object()
	{
		$this->x = new \stdClass();
	}

	public function _test_x_is_not_an_object()
	{
		$this->x = 123;
	}
}
