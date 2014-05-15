<?php

namespace Concise;

class AssertionTest extends TestCase
{
	public function testCreatingAssertionRequiresTheAssertionString()
	{
		$assertion = new Assertion('? equals ?', new Matcher\Equals());
		$this->assertEquals('? equals ?', $assertion->getAssertion());
	}

	public function testCreatingAssertionWithoutProvidingDataIsAnEmptyArray()
	{
		$assertion = new Assertion('? equals ?', new Matcher\Equals());
		$this->assertEquals(array(), $assertion->getData());
	}

	public function testSettingDataWhenCreatingAssertion()
	{
		$assertion = new Assertion('? equals ?', new Matcher\Equals(), array('abc', 'def'));
		$this->assertEquals(array('abc', 'def'), $assertion->getData());
	}

	public function testCreatingAssertionRequiresTheMatcher()
	{
		$matcher = new Matcher\Equals();
		$assertion = new Assertion('? equals ?', $matcher);
		$this->assertSame($matcher, $assertion->getMatcher());
	}

	public function testToStringRenderedData()
	{
		$matcher = new Matcher\Equals();
		$data = array(
			'a' => 123,
			'b' => 'abc',
			'c' => 'xyz'
		);
		$assertion = new Assertion('a equals b', $matcher, $data);
		$expected = "\n  a = 123\n  b = 'abc'\n  c = 'xyz'\n";
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

	public function testWillSucceedIfTheAssertionResultIsTrue()
	{
		$stub = $this->getMock('\Concise\Assertion',
			array('executeAssertion', 'success'),
			array('true', new Matcher\Boolean())
		);
		$stub->expects($this->once())
		     ->method('executeAssertion')
		     ->will($this->returnValue(true));
		$stub->expects($this->once())
		     ->method('success');

		$stub->run();
	}

	public function testCanSetDescriptiveString()
	{
		$assertion = new Assertion('? equals ?', new Matcher\Equals());
		$assertion->setDescription('my description');
		$this->assertEquals('my description (? equals ?)', $assertion->getDescription());
	}

	public function testDescriptionReturnsAssertionIfNotSet()
	{
		$assertion = new Assertion('? equals ?', new Matcher\Equals());
		$this->assertEquals('? equals ?', $assertion->getDescription());
	}

	public function testPrepareIsCalledAsPartOfTheAssertion()
	{
		$assertion = new Assertion('true', new Matcher\Boolean(), array(), true, false);

		$testCase = $this->getMock('\Concise\TestCase', array('prepare'));
		$testCase->expects($this->once())
		         ->method('prepare')
		         ->will($this->returnValue(null));
		$assertion->setTestCase($testCase);

		$assertion->run();
	}

	public function testFinalizeIsCalledAsPartOfTheAssertion()
	{
		$assertion = new Assertion('true', new Matcher\Boolean(), array(), false, true);

		$testCase = $this->getMock('\Concise\TestCase', array('finalize'));
		$testCase->expects($this->once())
		         ->method('finalize')
		         ->will($this->returnValue(null));
		$assertion->setTestCase($testCase);

		$assertion->run();
	}

	public function testShouldUsePrepareDefaultsToFalse()
	{
		$assertion = new Assertion('true', new Matcher\Boolean());
		$this->assertSame(false, $assertion->shouldRunPrepare());
	}

	public function testShouldUseFinalizeDefaultsToFalse()
	{
		$assertion = new Assertion('true', new Matcher\Boolean());
		$this->assertSame(false, $assertion->shouldRunFinalize());
	}

	public function testCanChangeStatusOfPrepareAfterConstructor()
	{
		$assertion = new Assertion('true', new Matcher\Boolean());
		$assertion->setShouldRunPrepare(true);
		$this->assertSame(true, $assertion->shouldRunPrepare());
	}

	public function testCanChangeStatusOfFinalizeAfterConstructor()
	{
		$assertion = new Assertion('true', new Matcher\Boolean());
		$assertion->setShouldRunFinalize(true);
		$this->assertSame(true, $assertion->shouldRunFinalize());
	}

	public function testCanSetShouldRunPrepareInConstructor()
	{
		$assertion = new Assertion('? equals ?', new Matcher\Equals(), array(), true);
		$this->assertSame(true, $assertion->shouldRunPrepare());
	}

	public function testCanSetShouldRunFinalizeInConstructor()
	{
		$assertion = new Assertion('? equals ?', new Matcher\Equals(), array(), true, true);
		$this->assertSame(true, $assertion->shouldRunFinalize());
	}

	public function testPrepareIsNotCalledIfFixturesAreSetNotToBeRun()
	{
		$assertion = new Assertion('true', new Matcher\Boolean(), array(), false);

		$testCase = $this->getMock('\Concise\TestCase', array('prepare'));
		$testCase->expects($this->never())
		         ->method('prepare')
		         ->will($this->returnValue(null));
		$assertion->setTestCase($testCase);

		$assertion->run();
	}

	public function testFinalizeIsNotCalledIfFixturesAreSetNotToBeRun()
	{
		$assertion = new Assertion('true', new Matcher\Boolean(), array(), false);

		$testCase = $this->getMock('\Concise\TestCase', array('finalize'));
		$testCase->expects($this->never())
		         ->method('finalize')
		         ->will($this->returnValue(null));
		$assertion->setTestCase($testCase);

		$assertion->run();
	}
}
