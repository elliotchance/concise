<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsNullTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsNull();
	}

	public function _test_null()
	{
		return '`null` is null';
	}
}
