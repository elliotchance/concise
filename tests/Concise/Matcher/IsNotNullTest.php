<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsNotNullTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsNotNull();
	}

	public function testZeroIsNotNull()
	{
		$this->assert('0 is not null');
	}

	public function testABlankStringIsNotNull()
	{
		$this->assert('"" is not null');
	}

	public function testFalseIsNotNull()
	{
		$this->assert('`false` is not null');
	}
}
