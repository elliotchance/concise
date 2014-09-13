<?php

namespace Concise\Matcher;

class IsABooleanTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsABoolean();
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
}
