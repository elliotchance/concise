<?php

namespace Concise\Services;

use \Concise\TestCase;

class AssertionBuilderTest extends TestCase
{
	public function testCanFindAssertionWithArguments()
	{
		$builder = new AssertionBuilder(array(123, 'equals', 123));
		$this->assertInstanceOf('\Concise\Matcher\Equals', $builder->getAssertion());
	}
}
