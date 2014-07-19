<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsAnEmptyArrayTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsAnEmptyArray();
	}

	public function testArrayWithZeroElements()
	{
		$this->assert(array(), is_empty_array);
	}
}
