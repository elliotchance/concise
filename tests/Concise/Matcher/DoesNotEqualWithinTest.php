<?php

namespace Concise\Matcher;

class DoesNotEqualWithinTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DoesNotEqualWithin();
    }

    public function testTwoValuesThatAreExactlyEqualWithZeroDelta()
    {
        $this->assertFailure(123.0, does_not_equal, 123.0, within, 0.0);
    }

    public function testTwoValuesThatAreNotEqualWithZeroDelta()
    {
        $this->assert(123.0, does_not_equal, 124.0, within, 0.0);
    }

    public function testComparingTwoValuesInsideTheDelta()
    {
        $this->assertFailure(123.0, does_not_equal, 125.0, within, 5.0);
    }

    public function testComparingTwoValuesOutsideTheDelta()
    {
        $this->assert(123, does_not_equal, 223, within, 5.0);
    }

    public function testComparingTwoValuesOutsideTheDeltainReverse()
    {
        $this->assert(223, does_not_equal, 123, within, 5.0);
    }

    public function tags()
    {
        return array(Tag::NUMBERS);
    }
}
