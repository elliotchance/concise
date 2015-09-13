<?php

namespace Concise;

use Concise\Module\BasicModule;
use Concise\Module\BooleanModule;
use Concise\Module\NumberModule;
use Concise\Syntax\ModuleManager;
use PHPUnit_Framework_AssertionFailedError;

class AssertionTest extends TestCase
{
    public function testCreatingAssertionRequiresTheAssertionString()
    {
        $assertion = new Assertion('? equals ?', new BasicModule());
        $this->assert($assertion->getAssertion())->equals('? equals ?');
    }

    public function testCreatingAssertionWithoutProvidingDataIsAnEmptyArray()
    {
        $assertion = new Assertion('? equals ?', new BasicModule());
        $this->assert($assertion->getData())->isAnEmptyArray;
    }

    public function testSettingDataWhenCreatingAssertion()
    {
        $assertion = new Assertion(
            '? equals ?',
            new BasicModule(),
            array('abc', 'def')
        );
        $this->assert($assertion->getData())->equals(array('abc', 'def'));
    }

    public function testCreatingAssertionRequiresTheMatcher()
    {
        $matcher = new BasicModule();
        $assertion = new Assertion('? equals ?', $matcher);
        $this->assert($matcher)->isTheSameAs($assertion->getMatcher());
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
        $this->assert((string)$assertion)->equals($expected);
    }

    public function testCanSetDescriptiveString()
    {
        $assertion = new Assertion('? equals ?', new BasicModule());
        $assertion->setDescription('my description');
        $this->assert($assertion->getDescription())
            ->equals('my description (? equals ?)');
    }

    public function testDescriptionReturnsAssertionIfNotSet()
    {
        $assertion = new Assertion('? equals ?', new BasicModule());
        $this->assert($assertion->getDescription())->equals('? equals ?');
    }

    /**
     * @param string $theAssertion
     */
    protected function compileAndRunAssertion($theAssertion)
    {
        $parser = ModuleManager::getInstance();
        $assertion = $parser->compile($theAssertion);
        $assertion->setTestCase($this);
        $assertion->run();
    }

    protected function getStubForAssertionThatReturnsData(array $data)
    {
        return $this->niceMock(
            '\Concise\Assertion',
            array('true', new BooleanModule())
        )
            ->stub(array('getData' => $data))
            ->get();
    }

    public function testDoNotShowPHPUnitPropertiesOnError()
    {
        $assertion = $this->getStubForAssertionThatReturnsData(
            self::getPHPUnitProperties()
        );
        $this->assert((string)$assertion)->isBlank;
    }

    public function testDoNotShowDataSetOnError()
    {
        $assertion = $this->getStubForAssertionThatReturnsData(
            array(
                '__dataSet' => array()
            )
        );
        $this->assert((string)$assertion)->isBlank;
    }

    public function testNoAttributesRendersAsAnEmptyString()
    {
        $assertion = $this->getStubForAssertionThatReturnsData(array());
        $this->assert((string)$assertion)->isBlank;
    }

    public function testCanSetCustomFailureMessage()
    {
        $assertion = new Assertion('true', new BooleanModule());
        $this->assert($assertion->setFailureMessage('foo'))->isNull;
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testAssertionMustBeAString()
    {
        new Assertion(123, new BooleanModule());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testOriginalSyntaxMustBeAString()
    {
        $assertion = new Assertion('true', new BooleanModule());
        $assertion->setOriginalSyntax(123);
    }

    /**
     * @group #219
     * @expectedException PHPUnit_Framework_AssertionFailedError
     */
    public function testDidNotMatchExceptionIsConvertedIntoAssertionFailedError(
    )
    {
        $assertion = $this->niceMock('Concise\Assertion')
            ->disableConstructor()
            ->expose('performMatch')
            ->stub(array('getMatcher' => new NumberModule()))
            ->get();

        $assertion->performMatch('? is between ? and ?', array(10, 0, 5));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Method Concise\Module\AbstractModule::match()
     *     does not exist.
     * @group #219
     */
    public function testAnyOtherTypeOfExceptionIsNotConvertedToAssertionFailedError(
    )
    {
        $matcher = $this->mock('\Concise\Module\AbstractModule')
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
                ->stub(array('getMatcher' => new NumberModule()))
                ->get();

            $assertion->performMatch('? is between ? and ?', array(10, 0, 5));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            $this->assert($e->getMessage())->containsString('is between');
            return;
        }

        $this->assert(false);
    }
}
