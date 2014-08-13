<?php

namespace Concise\Matcher;

class EqualsWithinTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new EqualsWithin();
    }

    public function testTwoValuesThatAreExactlyEqualWithZeroDelta()
    {
        $this->assert(123.0, equals, 123.0, within, 0.0);
    }

    public function testTwoValuesThatAreNotEqualWithZeroDelta()
    {
        $this->assertFailure(123.0, equals, 124.0, within, 0.0);
    }

    public function testComparingTwoValuesInsideTheDelta()
    {
        $this->assert(123.0, equals, 125.0, within, 5.0);
    }
}
