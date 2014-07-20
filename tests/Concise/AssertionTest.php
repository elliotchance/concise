<?php

namespace Concise;

use \Concise\Syntax\Code;
use \Concise\Syntax\MatcherParser;
use \Concise\Matcher\True;
use \Concise\Matcher\False;

class AssertionTest extends TestCase
{
	public function testCreatingAssertionRequiresTheAssertionString()
	{
		$assertion = new Assertion('? equals ?', new Matcher\Equals());
		$this->assert($assertion->getAssertion(), equals, '? equals ?');
	}

	public function testCreatingAssertionWithoutProvidingDataIsAnEmptyArray()
	{
		$assertion = new Assertion('? equals ?', new Matcher\Equals());
		$this->assert($assertion->getData(), is_an_empty_array);
	}

	public function testSettingDataWhenCreatingAssertion()
	{
		$assertion = new Assertion('? equals ?', new Matcher\Equals(), array('abc', 'def'));
		$this->assert($assertion->getData(), equals, array('abc', 'def'));
	}

	public function testCreatingAssertionRequiresTheMatcher()
	{
		$matcher = new Matcher\Equals();
		$assertion = new Assertion('? equals ?', $matcher);
		$this->assert($matcher, is_the_same_as, $assertion->getMatcher());
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
		$this->assert((string) $assertion, equals, $expected);
	}

	public function testCanSetDescriptiveString()
	{
		$assertion = new Assertion('? equals ?', new Matcher\Equals());
		$assertion->setDescription('my description');
		$this->assert($assertion->getDescription(), equals, 'my description (? equals ?)');
	}

	public function testDescriptionReturnsAssertionIfNotSet()
	{
		$assertion = new Assertion('? equals ?', new Matcher\Equals());
		$this->assert($assertion->getDescription(), equals, '? equals ?');
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

	protected function getStubForAssertionThatReturnsData(array $data)
	{
		return $this->getStub('\Concise\Assertion', array(
			'getData' => $data
		), array('true', new True()));
	}

	public function testDoNotShowPHPUnitPropertiesOnError()
	{
		$assertion = $this->getStubForAssertionThatReturnsData(self::getPHPUnitProperties());
		$this->assertEquals("", (string) $assertion);
	}

	public function testDoNotShowDataSetOnError()
	{
		$assertion = $this->getStubForAssertionThatReturnsData(array(
			'__dataSet' => array()
		));
		$this->assertEquals("", (string) $assertion);
	}

	public function testNoAttributesRendersAsAnEmptyString()
	{
		$assertion = $this->getStubForAssertionThatReturnsData(array());
		$this->assertEquals("", (string) $assertion);
	}
}
