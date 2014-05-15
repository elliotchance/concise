<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsObjectTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsObject();
	}

	public function _test_a_is_an_object()
	{
		$this->a = new \stdClass();
	}

	public function _test_a_is_not_an_object()
	{
		$this->a = 123;
	}
}
