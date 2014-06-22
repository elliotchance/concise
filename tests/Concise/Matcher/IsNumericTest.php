<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsNumericTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsNumeric();
	}

	public function testIntegerIsNumeric()
	{
		$this->assert('123 is numeric');
	}

	public function testFloatIsNumeric()
	{
		$this->assert('12.3 is numeric');
	}

	public function testStringIsNotNumeric()
	{
		$this->assertFailure('"abc" is numeric');
	}

	public function testStringThatRepresentsAnIntegerIsNumeric()
	{
		$this->assert('"123" is numeric');
	}

	public function testStringThatRepresentsAFloatIsNumeric()
	{
		$this->assert('"12.3" is numeric');
	}

	public function testStringThatRepresentsScientificNotationIsNumeric()
	{
		$this->assert('"12.3e-17" is numeric');
	}
}
