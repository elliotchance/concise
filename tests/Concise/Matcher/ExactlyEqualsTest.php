<?php

namespace Concise\Matcher;

class ExactlyEqualsTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new ExactlyEquals();
    }

    public function testExactlyEquals()
    {
        $this->assert('123 exactly equals 123');
    }

    public function testIntegerAndFloatWithTheSameValueAreNotExactlyEqual()
    {
        $this->assertFailure('123 exactly equals 123.0');
    }

    public function testIntegerAndItsStringRepresentationAreNotExactlyEqual()
    {
        $this->assertFailure('123 exactly equals "123"');
    }

    public function tags()
    {
        return array(Tag::BASIC);
    }
}
