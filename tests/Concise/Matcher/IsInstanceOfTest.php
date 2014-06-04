<?php

namespace Concise\Matcher;

class IsInstanceOfTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsInstanceOf();
	}

	public function _test_comparisons()
	{
		$this->x = new self();
		return array(
			'x is an instance of \Concise\Matcher\IsInstanceOfTest',
			'x instance of \Concise\Matcher\AbstractMatcherTestCase'
		);
	}
}
