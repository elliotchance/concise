<?php

namespace Concise\Matcher;

class IsTrueTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsTrue();
    }

    public function testIsTrue()
    {
        $this->assert(true, is_true);
    }

    public function testIsTrueFailure()
    {
        $this->assertFailure('123 is true');
    }

    public function testOneIsNotTrue()
    {
        $this->assertFailure('1 is true');
    }
}
