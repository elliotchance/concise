<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class AbstractMatcherTest extends TestCase
{
	public function testSuccessIsNull()
	{
		$this->assertNull(AbstractMatcher::SUCCESS);
	}
}
