<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsNotAnIntegerTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsNotAnInteger();
	}

	public function testStringThatRepresentsAnIntegerIsNotAnInteger()
	{
		$this->assert('"123" is not an integer');
	}

	public function testFloatThatIsAWholeNumberIsNotAnInteger()
	{
		$this->assert('1.0 is not an integer');
	}
}
