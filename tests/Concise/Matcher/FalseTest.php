<?php

namespace Concise\Matcher;

class FalseTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new False();
	}

	public function testAlwaysFails()
	{
		$this->assertFailure('false');
	}
}
