<?php

namespace Concise\Matcher;

class IsInstanceOfTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsInstanceOf();
	}

	public function comparisons()
	{
		return array(
			array('x is an instance of \Concise\Matcher\IsInstanceOfTest'),
			array('x instance of \Concise\Matcher\AbstractMatcherTestCase'),
		);
	}

	/**
	 * @dataProvider comparisons
	 */
	public function testComparisons($assertion)
	{
		$this->x = new self();
		$this->assert($assertion);
	}

	public function testFailure()
	{
		$this->assertMatcherFailure('? is instance of ?', array(
			new \stdClass(),
			'\Concise\Matcher\IsInstanceOfTest'
		));
	}
}
