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

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage No such matcher for syntax '? array ?'.
	 */
	public function testWillThrowExceptionIfAssertionCannotBeFound()
	{
		$builder = new AssertionBuilder(array('foo', 'array', 123));
		$builder->getAssertion();
	}
}
