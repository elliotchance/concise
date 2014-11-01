<?php

namespace Concise\Matcher;

class IsANumberTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsANumber();
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

    public function tags()
    {
        return array(Tag::NUMBERS, Tag::TYPES);
    }
}
