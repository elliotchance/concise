<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsNotAnEmptyArrayTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsNotAnEmptyArray();
	}

	public function testArrayWithZeroElements()
	{
		$this->assertFailure(array(), is_not_empty_array);
	}

	public function testArrayWithMoreThanZeroElements()
	{
		$this->assert(array('a'), is_not_empty_array);
	}
}
