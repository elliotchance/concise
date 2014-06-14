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

	public function testIsNull()
	{
		$this->assert('`null` is null');
	}
}
