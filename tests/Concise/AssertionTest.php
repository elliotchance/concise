<?php

namespace Concise;

use Concise\Matcher\Equals;
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

    protected function getStubForAssertionThatReturnsData(array $data)
    {
        return $this->niceMock('\Concise\Assertion', array('true', new True()))
                    ->stub(array('getData' => $data))
                    ->done();
    }

    public function testDoNotShowPHPUnitPropertiesOnError()
    {
        $assertion = $this->getStubForAssertionThatReturnsData(self::getPHPUnitProperties());
        $this->assert((string) $assertion, is_blank);
    }

    public function testDoNotShowDataSetOnError()
    {
        $assertion = $this->getStubForAssertionThatReturnsData(array(
            '__dataSet' => array()
        ));
        $this->assert((string) $assertion, is_blank);
    }

    public function testNoAttributesRendersAsAnEmptyString()
    {
        $assertion = $this->getStubForAssertionThatReturnsData(array());
        $this->assert((string) $assertion, is_blank);
    }

    public function testCanSetCustomFailureMessage()
    {
        $assertion = new Assertion('true', new True());
        $this->assert($assertion->setFailureMessage('foo'), is_null);
    }

    public function testWillFailWithCustomMessage()
    {
        try {
            $assertion = new Assertion('false', new False());
            $assertion->setFailureMessage('foo');
            $assertion->run();
            $this->fail('Did not fail.');
        } catch(\PHPUnit_Framework_AssertionFailedError $e) {
            $this->assert($e->getMessage(), equals, 'foo');
        }
    }
}
