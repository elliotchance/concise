<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class IsAnAssociativeArrayTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new IsAnAssociativeArray();
	}

	public function testAnAssociativeArrayContainsAtLeastOneKeyThatsNotANumber()
	{
		$this->x = array(
			"a" => 123,
			0 => "foo",
		);
		$this->assert('x is an associative array');
	}
}
