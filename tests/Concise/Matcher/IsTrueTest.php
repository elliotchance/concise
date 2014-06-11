<?php

namespace Concise\Matcher;

class IsTrueTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsTrue();
	}

	public function testComparisons()
	{
		$this->assert('`true` is true');
	}
}
