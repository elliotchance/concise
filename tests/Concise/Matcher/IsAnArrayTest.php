<?php

namespace Concise\Matcher;

class IsAnArrayTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsAnArray();
    }

    public function testIsAnArray()
    {
        $this->assert('[] is an array');
    }

    public function testIsAnArrayFailure()
    {
        $this->assertFailure('123 is an array');
    }
}
