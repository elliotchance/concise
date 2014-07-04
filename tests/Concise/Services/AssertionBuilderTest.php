<?php

namespace Concise\Services;

use \Concise\TestCase;

class AssertionBuilderTest extends TestCase
{
	public function testCanFindAssertionWithArguments()
	{
		$builder = new AssertionBuilder(array(123, 'equals', 123));
		$assertion = $builder->getAssertion();
		assertThat($assertion->getMatcher(), instance_of, '\Concise\Matcher\Equals');
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

	public function testAssertionBuilderWillAcceptTrue()
	{
		$builder = new AssertionBuilder(array(true));
		$assertion = $builder->getAssertion();
		$this->assert($assertion->getMatcher(), instance_of, '\Concise\Matcher\True');
	}

	public function testAssertionBuilderWillAcceptFalse()
	{
		$builder = new AssertionBuilder(array(false));
		$assertion = $builder->getAssertion();
		$this->assert($assertion->getMatcher(), instance_of, '\Concise\Matcher\False');
	}
}
