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
        $this->assert(true, is_a_boolean);
    }

    public function testAStringIsNotABoolean()
    {
        $this->assertFailure("true", is_a_boolean);
    }

    public function testFalseIsABoolean()
    {
        $this->assert(false, is_a_boolean);
    }

    public function testAlternativeShorterSyntax()
    {
        $this->assert(true, is_a_bool);
    }

    public function testIsAnArray()
    {
        $this->assert('[] is an array');
    }

    public function testIsAnArrayFailure()
    {
        $this->assertFailure('123 is an array');
    }

    public function testIntegerIsAnInteger()
    {
        $this->assert('123 is an integer');
    }

    public function testFloatIsNotAnInteger()
    {
        $this->assertFailure('123.0 is an integer');
    }

    public function testStringThatRepresentsAnIntegerIsNotAnInteger()
    {
        $this->assertFailure('"123" is an integer');
    }

    public function testIsAnObject()
    {
        $this->assert(new \stdClass(), is_an_object);
    }

    public function testIsAnObjectFailure()
    {
        $this->assertFailure('123 is an object');
    }

    public function testIntegerIsANumber()
    {
        $this->assert('123 is a number');
    }

    public function testStringThatRepresentsANumberIsNotANumber()
    {
        $this->assertFailure('"123" is a number');
    }

    public function testFloatIsANumber()
    {
        $this->assert('12.3 is a number');
    }

    public function testIsAString()
    {
        $this->assert('"123" is a string');
    }

    public function testIsAStringFailure()
    {
        $this->assertFailure('123 is a string');
    }

    public function testClassNameIsAString()
    {
        $this->assert('\My\Class is a string');
    }

    public function testIsInstanceOfWithSameClass()
    {
        $this->assert(
            new self(),
            is_an_instance_of,
            '\Concise\Module\TypeModuleTest'
        );
    }

    public function testIsInstanceOfWithSuperClass()
    {
        $this->assert(
            new self(),
            instance_of,
            '\Concise\Module\AbstractModuleTestCase'
        );
    }

    public function testIsInstanceOfFailure()
    {
        $this->assertFailure(
            new \stdClass(),
            is_instance_of,
            '\Concise\Module\TypeModule'
        );
    }

    public function testStringsRepresentingClassNamesCanBeUsed()
    {
        $this->assert(
            '\Concise\Module\TypeModule',
            instance_of,
            '\Concise\TestCase'
        );
    }

    public function testIsInstanceOfWithSameClassNoPrefix()
    {
        $this->assert(
            new self(),
            is_an_instance_of,
            'Concise\Module\TypeModuleTest'
        );
    }

    public function testTrueIsABoolean1()
    {
        $this->assertFailure(true, is_not_a_boolean);
    }

    public function testAStringIsNotABoolean1()
    {
        $this->assert("true", is_not_a_boolean);
    }

    public function testFalseIsABoolean1()
    {
        $this->assertFailure(false, is_not_a_boolean);
    }

    public function testAlternativeShorterSyntax1()
    {
        $this->assertFailure(true, is_not_a_bool);
    }

    public function testIsNotAnArray()
    {
        $this->assert('123 is not an array');
    }

    public function testIsNotAnArrayFailure()
    {
        $this->assertFailure('[] is not an array');
    }

    public function testStringThatRepresentsAnIntegerIsNotAnInteger1()
    {
        $this->assert('"123" is not an integer');
    }

    public function testFloatThatIsAWholeNumberIsNotAnInteger()
    {
        $this->assert('1.0 is not an integer');
    }

    public function testIsNotAnIntegerFailure()
    {
        $this->assertFailure('123 is not an integer');
    }

    public function testIsNotAnObject()
    {
        $this->assert('123 is not an object');
    }

    public function testClassNameIsNotAnObject()
    {
        $this->assert('\My\Class is not an object');
    }

    public function testIsNotAnObjectFailure()
    {
        $this->assertFailure(new stdClass(), is_not_an_object);
    }

    public function testIntegerIsANumber1()
    {
        $this->assertFailure('123 is not a number');
    }

    public function testStringThatRepresentsANumberIsNotANumber1()
    {
        $this->assert('"123" is not a number');
    }

    public function testFloatIsANumber1()
    {
        $this->assertFailure('12.3 is not a number');
    }

    public function testIsNotAString()
    {
        $this->assert('123 is not a string');
    }

    public function testIsNotAStringFailure()
    {
        $this->assertFailure('"123" is not a string');
    }

    public function testIsInstanceOfWithSameClass1()
    {
        $this->assertFailure(
            new self(),
            is_not_an_instance_of,
            '\Concise\Module\TypeModuleTest'
        );
    }

    public function testIsInstanceOfWithSuperClass1()
    {
        $this->assertFailure(
            new self(),
            not_instance_of,
            '\Concise\Module\AbstractModuleTestCase'
        );
    }

    public function testIsInstanceOfFailure1()
    {
        $this->assert(
            new \stdClass(),
            is_not_instance_of,
            '\Concise\Module\TypeModuleTest'
        );
    }

    public function testStringsRepresentingClassNamesCanBeUsed1()
    {
        $this->assertFailure(
            '\Concise\Module\TypeModule',
            is_not_instance_of,
            '\Concise\TestCase'
        );
    }

    public function testZeroIsNotNull()
    {
        $this->assert('0 is not null');
    }

    public function testABlankStringIsNotNull()
    {
        $this->assert('"" is not null');
    }

    public function testFalseIsNotNull()
    {
        $this->assert(false, is_not_null);
    }

    public function testIsNotNullFailure()
    {
        $this->assertFailure(null, is_not_null);
    }

    public function testIntegerIsNumeric()
    {
        $this->assertFailure('123 is not numeric');
    }

    public function testFloatIsNumeric()
    {
        $this->assertFailure('12.3 is not numeric');
    }

    public function testStringIsNotNumeric()
    {
        $this->assert('"abc" is not numeric');
    }

    public function testStringThatRepresentsAnIntegerIsNumeric()
    {
        $this->assertFailure('"123" is not numeric');
    }

    public function testStringThatRepresentsAFloatIsNumeric()
    {
        $this->assertFailure('"12.3" is not numeric');
    }

    public function testStringThatRepresentsScientificNotationIsNumeric()
    {
        $this->assertFailure('"12.3e-17" is not numeric');
    }

    public function testIsNull()
    {
        $this->assert(null, is_null);
    }

    public function testIsNullFailure()
    {
        $this->assertFailure('123 is null');
    }

    public function testIntegerIsNumeric1()
    {
        $this->assert('123 is numeric');
    }

    public function testFloatIsNumeric1()
    {
        $this->assert('12.3 is numeric');
    }

    public function testStringIsNotNumeric1()
    {
        $this->assertFailure('"abc" is numeric');
    }

    public function testStringThatRepresentsAnIntegerIsNumeric1()
    {
        $this->assert('"123" is numeric');
    }

    public function testStringThatRepresentsAFloatIsNumeric1()
    {
        $this->assert('"12.3" is numeric');
    }

    public function testStringThatRepresentsScientificNotationIsNumeric1()
    {
        $this->assert('"12.3e-17" is numeric');
    }
}
