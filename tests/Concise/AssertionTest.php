<?php

namespace Concise;

class AssertionTest extends TestCase
{
	public function testCreatingAssertionRequiresTheAssertionString()
	{
		$assertion = new Assertion('? equals ?', new Matcher\EqualTo());
		$this->assertEquals('? equals ?', $assertion->getAssertion());
	}

	public function testCreatingAssertionWithoutProvidingDataIsAnEmptyArray()
	{
		$assertion = new Assertion('? equals ?', new Matcher\EqualTo());
		$this->assertEquals(array(), $assertion->getData());
	}

	public function testSettingDataWhenCreatingAssertion()
	{
		$assertion = new Assertion('? equals ?', new Matcher\EqualTo(), array('abc', 'def'));
		$this->assertEquals(array('abc', 'def'), $assertion->getData());
	}

	public function testCreatingAssertionRequiresTheMatcher()
	{
		$matcher = new Matcher\EqualTo();
		$assertion = new Assertion('? equals ?', $matcher);
		$this->assertSame($matcher, $assertion->getMatcher());
	}

	public function testToStringRenderedData()
	{
		$matcher = new Matcher\EqualTo();
		$data = array(
			'a' => 123,
			'b' => 'abc',
			'c' => 'xyz'
		);
		$assertion = new Assertion('a equals b', $matcher, $data);
		$expected = "\n  a = 123\n  b = abc\n  c = xyz\n";
		$this->assertEquals($expected, (string) $assertion);
	}

	public function testWillFailIfTheAssertionMessageIsNotEmpty()
	{
		$stub = $this->getMock('\Concise\Assertion',
			array('executeAssertion', 'fail'),
			array('true', new Matcher\Boolean())
		);
		$stub->expects($this->once())
		     ->method('executeAssertion')
		     ->will($this->returnValue('oh no'));
		$stub->expects($this->once())
		     ->method('fail')
		     ->with('oh no');

		$stub->run();
	}

	public function testWillSucceedIfTheAssertionMessageIsNull()
	{
		$stub = $this->getMock('\Concise\Assertion',
			array('executeAssertion', 'success'),
			array('true', new Matcher\Boolean())
		);
		$stub->expects($this->once())
		     ->method('executeAssertion')
		     ->will($this->returnValue(null));
		$stub->expects($this->once())
		     ->method('success');

		$stub->run();
	}
}
