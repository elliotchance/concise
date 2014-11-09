<?php

namespace Concise\Matcher;

class IsNotABooleanTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsNotABoolean();
    }

    public function testTrueIsABoolean()
    {
        $this->assertFailure(true, is_not_a_boolean);
    }

    public function testAStringIsNotABoolean()
    {
        $this->assert("true", is_not_a_boolean);
    }

    public function testFalseIsABoolean()
    {
        $this->assertFailure(false, is_not_a_boolean);
    }

    public function testAlternativeShorterSyntax()
    {
        $this->assertFailure(true, is_not_a_bool);
    }

    public function tags()
    {
        return array(Tag::BOOLEANS, Tag::TYPES);
    }
}
