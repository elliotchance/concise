<?php

namespace Concise\Modules\Types;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class IsNotNumericTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsNotNumeric();
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
}
