<?php

namespace Concise;

use \Concise\Syntax\Code;
use \Concise\Syntax\MatcherParser;
use \Concise\Matcher\True;

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
		$expected = "\n  a (integer) = 123\n  b (string) = \"abc\"\n  c (string) = \"xyz\"\n";
		$this->assertEquals($expected, (string) $assertion);
	}

	public function testWillFailIfTheAssertionMessageIsNotEmpty()
	{
		$stub = $this->getMock('\Concise\Assertion',
			array('executeAssertion', 'fail'),
			array('true', new Matcher\True())
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
			array('true', new Matcher\True())
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

	/**
	 * @param string $theAssertion
	 */
	protected function compileAndRunAssertion($theAssertion)
	{
		$parser = MatcherParser::getInstance();
		$assertion = $parser->compile($theAssertion);
		$assertion->setTestCase($this);
		$assertion->run();
	}

	public function testAssertionWillEvaluateCodeBlocks()
	{
		$this->compileAndRunAssertion('`1 + 2` equals 3');
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Could not compile code block '1 + ':
	 */
	public function testAssertionWillThrowExceptionIfCodeBlockCannotCompile()
	{
		$this->compileAndRunAssertion('`1 + ` equals 3');
	}

	public function testAssertionWillNotThrowExceptionIfCodeBlockReturnsFalse()
	{
		$this->compileAndRunAssertion('`false` equals `false`');
	}

	public function testAssertionCodeCanUseAttributes()
	{
		$this->x = 123;
		$this->assert('`$self->x` equals 123');
	}

	public function testDoNotShowPHPUnitPropertiesOnError()
	{
		$assertion = $this->getStub('\Concise\Assertion', array(
			'getData' => self::getPHPUnitProperties()
		), array('true', new True()));
		$this->assertEquals("", (string) $assertion);
	}

	public function testDoNotShowDataSetOnError()
	{
		$assertion = $this->getStub('\Concise\Assertion', array(
			'getData' => array(
				'__dataSet' => array()
			)
		), array('true', new True()));
		$this->assertEquals("", (string) $assertion);
	}

	public function testNoAttributesRendersAsAnEmptyString()
	{
		$assertion = $this->getStub('\Concise\Assertion', array(
			'getData' => array()
		), array('true', new True()));
		$this->assertEquals("", (string) $assertion);
	}
}
