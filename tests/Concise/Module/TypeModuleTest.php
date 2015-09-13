<?php

namespace Concise\Module;

use stdClass;

/**
 * @group matcher
 */
class TypeModuleTest extends AbstractModuleTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new TypeModule();
    }

    public function testTrueIsABoolean()
    {
        $this->assert(true)->isABoolean;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testAStringIsNotABoolean()
    {
        $this->assert("true")->isABoolean;
    }

    public function testFalseIsABoolean()
    {
        $this->assert(false)->isABoolean;
    }

    public function testAlternativeShorterSyntax()
    {
        $this->assert(true)->isABool;
    }

    public function testIsAnArray()
    {
        $this->assert(array())->isAnArray;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsAnArrayFailure()
    {
        $this->assert(123)->isAnArray;
    }

    public function testIntegerIsAnInteger()
    {
        $this->assert(123)->isAnInteger;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFloatIsNotAnInteger()
    {
        $this->assert(123.0)->isAnInteger;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringThatRepresentsAnIntegerIsNotAnInteger()
    {
        $this->assert("123")->isAnInteger;
    }

    public function testIsAnObject()
    {
        $this->assert(new \stdClass())->isAnObject;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsAnObjectFailure()
    {
        $this->assert(123)->isAnObject;
    }

    public function testIntegerIsANumber()
    {
        $this->assert(123)->isANumber;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringThatRepresentsANumberIsNotANumber()
    {
        $this->assert("123")->isANumber;
    }

    public function testFloatIsANumber()
    {
        $this->assert(12.3)->isANumber;
    }

    public function testIsAString()
    {
        $this->assert("123")->isAString;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsAStringFailure()
    {
        $this->assert(123)->isAString;
    }

    public function testClassNameIsAString()
    {
        $this->assert('\My\Class')->isAString;
    }

    public function testIsInstanceOfWithSameClass()
    {
        $this->assert(new self())
            ->isAnInstanceOf('\Concise\Module\TypeModuleTest');
    }

    public function testIsInstanceOfWithSuperClass()
    {
        $this->assert(new self())
            ->instanceOf('\Concise\Module\AbstractModuleTestCase');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsInstanceOfFailure()
    {
        $this->assert(new \stdClass())
            ->isInstanceOf('\Concise\Module\TypeModule');
    }

    public function testStringsRepresentingClassNamesCanBeUsed()
    {
        $this->assert('\Concise\Module\TypeModule')
            ->instanceOf('\Concise\Core\TestCase');
    }

    public function testIsInstanceOfWithSameClassNoPrefix()
    {
        $this->assert(new self())
            ->isAnInstanceOf('Concise\Module\TypeModuleTest');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testTrueIsABoolean1()
    {
        $this->assert(true)->isNotABoolean;
    }

    public function testAStringIsNotABoolean1()
    {
        $this->assert("true")->isNotABoolean;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFalseIsABoolean1()
    {
        $this->assert(false)->isNotABoolean;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testAlternativeShorterSyntax1()
    {
        $this->assert(true)->isNotABool;
    }

    public function testIsNotAnArray()
    {
        $this->assert(123)->isNotAnArray;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsNotAnArrayFailure()
    {
        $this->assert(array())->isNotAnArray;
    }

    public function testStringThatRepresentsAnIntegerIsNotAnInteger1()
    {
        $this->assert("123")->isNotAnInteger;
    }

    public function testFloatThatIsAWholeNumberIsNotAnInteger()
    {
        $this->assert(1.0)->isNotAnInteger;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsNotAnIntegerFailure()
    {
        $this->assert(123)->isNotAnInteger;
    }

    public function testIsNotAnObject()
    {
        $this->assert(123)->isNotAnObject;
    }

    public function testClassNameIsNotAnObject()
    {
        $this->assert('\My\Class')->isNotAnObject;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsNotAnObjectFailure()
    {
        $this->assert(new stdClass())->isNotAnObject;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIntegerIsANumber1()
    {
        $this->assert(123)->isNotANumber;
    }

    public function testStringThatRepresentsANumberIsNotANumber1()
    {
        $this->assert("123")->isNotANumber;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFloatIsANumber1()
    {
        $this->assert(12.3)->isNotANumber;
    }

    public function testIsNotAString()
    {
        $this->assert(123)->isNotAString;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsNotAStringFailure()
    {
        $this->assert("123")->isNotAString;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsInstanceOfWithSuperClass1()
    {
        $this->assert(new self())
            ->notInstanceOf('\Concise\Module\AbstractModuleTestCase');
    }

    public function testIsInstanceOfFailure1()
    {
        $this->assert(new \stdClass())
            ->isNotInstanceOf('\Concise\Module\TypeModuleTest');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringsRepresentingClassNamesCanBeUsed1()
    {
        $this->assert('\Concise\Module\TypeModule')
            ->isNotInstanceOf('\Concise\Core\TestCase');
    }

    public function testZeroIsNotNull()
    {
        $this->assert(0)->isNotNull;
    }

    public function testABlankStringIsNotNull()
    {
        $this->assert("")->isNotNull;
    }

    public function testFalseIsNotNull()
    {
        $this->assert(false)->isNotNull;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsNotNullFailure()
    {
        $this->assert(null)->isNotNull;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIntegerIsNumeric()
    {
        $this->assert(123)->isNotNumeric;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFloatIsNumeric()
    {
        $this->assert(12.3)->isNotNumeric;
    }

    public function testStringIsNotNumeric()
    {
        $this->assert("abc")->isNotNumeric;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringThatRepresentsAnIntegerIsNumeric()
    {
        $this->assert("123")->isNotNumeric;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringThatRepresentsAFloatIsNumeric()
    {
        $this->assert("12.3")->isNotNumeric;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringThatRepresentsScientificNotationIsNumeric()
    {
        $this->assert("12.3e-17")->isNotNumeric;
    }

    public function testIsNull()
    {
        $this->assert(null)->isNull;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsNullFailure()
    {
        $this->assert(123)->isNull;
    }

    public function testIntegerIsNumeric1()
    {
        $this->assert(1230)->isNumeric;
    }

    public function testFloatIsNumeric1()
    {
        $this->assert(12.3)->isNumeric;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringIsNotNumeric1()
    {
        $this->assert("abc")->isNumeric;
    }

    public function testStringThatRepresentsAnIntegerIsNumeric1()
    {
        $this->assert("123")->isNumeric;
    }

    public function testStringThatRepresentsAFloatIsNumeric1()
    {
        $this->assert("12.3")->isNumeric;
    }

    public function testStringThatRepresentsScientificNotationIsNumeric1()
    {
        $this->assert("12.3e-17")->isNumeric;
    }
}
