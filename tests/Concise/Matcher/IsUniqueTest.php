<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsUniqueTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsUnique();
	}

	public function testArrayIsUniqueIfItContainsZeroElements()
	{
		$this->assert('[] is unique');
	}
}
