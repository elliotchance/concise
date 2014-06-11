<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class ExactlyEqualsTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new ExactlyEquals();
	}

	public function testComparison()
	{
		$this->assert('123 exactly equals 123');
	}
}
