<?php

namespace Concise\Matcher;

class HasKeysTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new HasKeys();
	}

	public function testArrayHasOneKey()
	{
		$this->assert('[123] has keys [0]');
	}
}
