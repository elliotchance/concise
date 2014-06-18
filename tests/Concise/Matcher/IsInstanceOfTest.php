<?php

namespace Concise\Matcher;

class IsInstanceOfTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsInstanceOf();
	}

	public function testIsInstanceOfWithSameClass()
	{
		$this->x = new self();
		$this->assert('x is an instance of \Concise\Matcher\IsInstanceOfTest');
	}

	public function testIsInstanceOfWithSuperClass()
	{
		$this->x = new self();
		$this->assert('x instance of \Concise\Matcher\AbstractMatcherTestCase');
	}

	public function testIsInstanceOfFailure()
	{
		$this->assertFailure('`new \stdClass()` is instance of \Concise\Matcher\IsInstanceOfTest');
	}
}
