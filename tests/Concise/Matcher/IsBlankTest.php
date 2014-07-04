<?php

namespace Concise\Matcher;

class IsBlankTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsBlank();
	}

	public function testStringWithNoCharactersIsBlank()
	{
		$this->assert('', is_blank);
	}
}
