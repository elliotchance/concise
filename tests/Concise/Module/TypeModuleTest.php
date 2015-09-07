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
        $this->aassert(true)->isABoolean;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testAStringIsNotABoolean()
    {
        $this->aassert("true")->isABoolean;
    }

    public function testFalseIsABoolean()
    {
        $this->aassert(false)->isABoolean;
    }

    public function testAlternativeShorterSyntax()
    {
        $this->aassert(true)->isABool;
    }

    public function testIsAnArray()
    {
        $this->aassert(array())->isAnArray;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsAnArrayFailure()
    {
        $this->aassert(123)->isAnArray;
    }

    public function testIntegerIsAnInteger()
    {
        $this->aassert(123)->isAnInteger;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFloatIsNotAnInteger()
    {
        $this->aassert(123.0)->isAnInteger;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringThatRepresentsAnIntegerIsNotAnInteger()
    {
        $this->aassert("123")->isAnInteger;
    }

    public function testIsAnObject()
    {
        $this->aassert(new \stdClass())->isAnObject;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsAnObjectFailure()
    {
        $this->aassert(123)->isAnObject;
    }

    public function testIntegerIsANumber()
    {
        $this->aassert(123)->isANumber;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringThatRepresentsANumberIsNotANumber()
    {
        $this->aassert("123")->isANumber;
    }

    public function testFloatIsANumber()
    {
        $this->aassert(12.3)->isANumber;
    }

    public function testIsAString()
    {
        $this->aassert("123")->isAString;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsAStringFailure()
    {
        $this->aassert(123)->isAString;
    }

    public function testClassNameIsAString()
    {
        $this->aassert('\My\Class')->isAString;
    }

    public function testIsInstanceOfWithSameClass()
    {
        $this->aassert(new self())
            ->isAnInstanceOf('\Concise\Module\TypeModuleTest');
    }

    public function testIsInstanceOfWithSuperClass()
    {
        $this->aassert(new self())
            ->instanceOf('\Concise\Module\AbstractModuleTestCase');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsInstanceOfFailure()
    {
        $this->aassert(new \stdClass())
            ->isInstanceOf('\Concise\Module\TypeModule');
    }

    public function testStringsRepresentingClassNamesCanBeUsed()
    {
        $this->aassert('\Concise\Module\TypeModule')
            ->instanceOf('\Concise\TestCase');
    }

    public function testIsInstanceOfWithSameClassNoPrefix()
    {
        $this->aassert(new self())
            ->isAnInstanceOf('Concise\Module\TypeModuleTest');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testTrueIsABoolean1()
    {
        $this->aassert(true)->isNotABoolean;
    }

    public function testAStringIsNotABoolean1()
    {
        $this->aassert("true")->isNotABoolean;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFalseIsABoolean1()
    {
        $this->aassert(false)->isNotABoolean;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testAlternativeShorterSyntax1()
    {
        $this->aassert(true)->isNotABool;
    }

    public function testIsNotAnArray()
    {
        $this->aassert(123)->isNotAnArray;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsNotAnArrayFailure()
    {
        $this->aassert(array())->isNotAnArray;
    }

    public function testStringThatRepresentsAnIntegerIsNotAnInteger1()
    {
        $this->aassert("123")->isNotAnInteger;
    }

    public function testFloatThatIsAWholeNumberIsNotAnInteger()
    {
        $this->aassert(1.0)->isNotAnInteger;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsNotAnIntegerFailure()
    {
        $this->aassert(123)->isNotAnInteger;
    }

    public function testIsNotAnObject()
    {
        $this->aassert(123)->isNotAnObject;
    }

    public function testClassNameIsNotAnObject()
    {
        $this->aassert('\My\Class')->isNotAnObject;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsNotAnObjectFailure()
    {
        $this->aassert(new stdClass())->isNotAnObject;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIntegerIsANumber1()
    {
        $this->aassert(123)->isNotANumber;
    }

    public function testStringThatRepresentsANumberIsNotANumber1()
    {
        $this->aassert("123")->isNotANumber;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFloatIsANumber1()
    {
        $this->aassert(12.3)->isNotANumber;
    }

    public function testIsNotAString()
    {
        $this->aassert(123)->isNotAString;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsNotAStringFailure()
    {
        $this->aassert("123")->isNotAString;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsInstanceOfWithSuperClass1()
    {
        $this->aassert(new self())
            ->notInstanceOf('\Concise\Module\AbstractModuleTestCase');
    }

    public function testIsInstanceOfFailure1()
    {
        $this->aassert(new \stdClass())
            ->isNotInstanceOf('\Concise\Module\TypeModuleTest');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringsRepresentingClassNamesCanBeUsed1()
    {
        $this->aassert('\Concise\Module\TypeModule')
            ->isNotInstanceOf('\Concise\TestCase');
    }

    public function testZeroIsNotNull()
    {
        $this->aassert(0)->isNotNull;
    }

    public function testABlankStringIsNotNull()
    {
        $this->aassert("")->isNotNull;
    }

    public function testFalseIsNotNull()
    {
        $this->aassert(false)->isNotNull;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsNotNullFailure()
    {
        $this->aassert(null)->isNotNull;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIntegerIsNumeric()
    {
        $this->aassert(123)->isNotNumeric;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFloatIsNumeric()
    {
        $this->aassert(12.3)->isNotNumeric;
    }

    public function testStringIsNotNumeric()
    {
        $this->aassert("abc")->isNotNumeric;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringThatRepresentsAnIntegerIsNumeric()
    {
        $this->aassert("123")->isNotNumeric;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringThatRepresentsAFloatIsNumeric()
    {
        $this->aassert("12.3")->isNotNumeric;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringThatRepresentsScientificNotationIsNumeric()
    {
        $this->aassert("12.3e-17")->isNotNumeric;
    }

    public function testIsNull()
    {
        $this->aassert(null)->isNull;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsNullFailure()
    {
        $this->aassert(123)->isNull;
    }

    public function testIntegerIsNumeric1()
    {
        $this->aassert(1230)->isNumeric;
    }

    public function testFloatIsNumeric1()
    {
        $this->aassert(12.3)->isNumeric;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringIsNotNumeric1()
    {
        $this->aassert("abc")->isNumeric;
    }

    public function testStringThatRepresentsAnIntegerIsNumeric1()
    {
        $this->aassert("123")->isNumeric;
    }

    public function testStringThatRepresentsAFloatIsNumeric1()
    {
        $this->aassert("12.3")->isNumeric;
    }

    public function testStringThatRepresentsScientificNotationIsNumeric1()
    {
        $this->aassert("12.3e-17")->isNumeric;
    }
}
