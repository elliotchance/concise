<?php

namespace Concise;

use Concise\Modules\BasicModule;
use Concise\Modules\Booleans\False;
use Concise\Modules\Booleans\True;
use Concise\Modules\Numbers\Between;
use Concise\Syntax\MatcherParser;
use PHPUnit_Framework_AssertionFailedError;

class AssertionTest extends TestCase
{
    public function testCreatingAssertionRequiresTheAssertionString()
    {
        $assertion = new Assertion('? equals ?', new BasicModule());
        $this->assert($assertion->getAssertion(), equals, '? equals ?');
    }

    public function testCreatingAssertionWithoutProvidingDataIsAnEmptyArray()
    {
        $assertion = new Assertion('? equals ?', new BasicModule());
        $this->assert($assertion->getData(), is_an_empty_array);
    }

    public function testSettingDataWhenCreatingAssertion()
    {
        $assertion = new Assertion(
            '? equals ?',
            new BasicModule(),
            array('abc', 'def')
        );
        $this->assert($assertion->getData(), equals, array('abc', 'def'));
    }

    public function testCreatingAssertionRequiresTheMatcher()
    {
        $matcher = new BasicModule();
        $assertion = new Assertion('? equals ?', $matcher);
        $this->assert($matcher, is_the_same_as, $assertion->getMatcher());
    }

    public function testToStringRenderedData()
    {
        $matcher = new BasicModule();
        $data = array(
            'a' => 123,
            'b' => 'abc',
            'c' => 'xyz'
        );
        $assertion = new Assertion('a equals b', $matcher, $data);
        $expected =
            "\n  a (integer) = 123\n  b (string) = \"abc\"\n  c (string) = \"xyz\"\n";
        $this->assert((string)$assertion, equals, $expected);
    }

    public function testCanSetDescriptiveString()
    {
        $assertion = new Assertion('? equals ?', new BasicModule());
        $assertion->setDescription('my description');
        $this->assert(
            $assertion->getDescription(),
            equals,
            'my description (? equals ?)'
        );
    }

    public function testDescriptionReturnsAssertionIfNotSet()
    {
        $assertion = new Assertion('? equals ?', new BasicModule());
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
            ->get();
    }

    public function testDoNotShowPHPUnitPropertiesOnError()
    {
        $assertion = $this->getStubForAssertionThatReturnsData(
            self::getPHPUnitProperties()
        );
        $this->assert((string)$assertion, is_blank);
    }

    public function testDoNotShowDataSetOnError()
    {
        $assertion = $this->getStubForAssertionThatReturnsData(
            array(
                '__dataSet' => array()
            )
        );
        $this->assert((string)$assertion, is_blank);
    }

    public function testNoAttributesRendersAsAnEmptyString()
    {
        $assertion = $this->getStubForAssertionThatReturnsData(array());
        $this->assert((string)$assertion, is_blank);
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
            $assertion->setTestCase($this);
            $assertion->setFailureMessage('foo');
            $assertion->run();
            $this->fail('Did not fail.');
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            $this->assert($e->getMessage(), equals, 'foo');
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testAssertionMustBeAString()
    {
        new Assertion(123, new True());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testOriginalSyntaxMustBeAString()
    {
        $assertion = new Assertion('true', new True());
        $assertion->setOriginalSyntax(123);
    }

    /**
     * @group #219
     */
    public function testDidNotMatchExceptionIsConvertedIntoAssertionFailedError()
    {
        $self = $this;
        $block = function () use ($self) {
            $assertion = $self->niceMock('Concise\Assertion')
                ->disableConstructor()
                ->expose('performMatch')
                ->stub(array('getMatcher' => new Between()))
                ->get();

            $assertion->performMatch('? is between ? and ?', array(10, 0, 5));
        };
        $this->assert(
            $block,
            throws,
            'PHPUnit_Framework_AssertionFailedError'
        );
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Method Concise\Matcher\AbstractMatcher::match() does not exist.
     * @group #219
     */
    public function testAnyOtherTypeOfExceptionIsNotConvertedToAssertionFailedError()
    {
        $matcher = $this->mock('\Concise\Matcher\AbstractMatcher')
            ->stub('match')
            ->andThrow(new \Exception('foobar'))
            ->get();
        $assertion =
            $this->niceMock('Concise\Assertion')->disableConstructor()->expose(
                'performMatch'
            )->stub(array('getMatcher' => $matcher))->get();

        $assertion->performMatch('? is between ? and ?', array(10, 0, 5));
    }

    /**
     * @group #219
     */
    public function testDidNotMatchExceptionWithNoMessageWillUseSyntaxRenderer()
    {
        try {
            $assertion = $this->niceMock('Concise\Assertion')
                ->disableConstructor()
                ->expose('performMatch')
                ->stub(array('getMatcher' => new Between()))
                ->get();

            $assertion->performMatch('? is between ? and ?', array(10, 0, 5));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            $this->assert($e->getMessage(), contains_string, 'is between');
            return;
        }
        $this->assert(false);
    }
}
