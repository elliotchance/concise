<?php

namespace Concise;

class AssertionTest extends TestCase
{
	public function testCreatingAssertionRequiresTheAssertionString()
	{
		$assertion = new Assertion('some string');
		$this->assertEquals('some string', $assertion->getAssertion());
	}

	public function testCreatingAssertionWithoutProvidingDataIsAnEmptyArray()
	{
		$assertion = new Assertion('some string');
		$this->assertEquals(array(), $assertion->getData());
	}

	public function testSettingDataWhenCreatingAssertion()
	{
		$assertion = new Assertion('some string', array('abc', 'def'));
		$this->assertEquals(array('abc', 'def'), $assertion->getData());
	}
}
