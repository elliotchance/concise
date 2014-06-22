<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsANumberTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsANumber();
	}

	public function testIntegerIsANumber()
	{
		$this->assert('123 is a number');
	}

	public function testStringThatRepresentsANumberIsNotANumber()
	{
		$this->assertFailure('"123" is a number');
	}

	public function testFloatIsANumber()
	{
		$this->assert('12.3 is a number');
	}
}
