<?php

namespace Concise\Matcher;

class EqualsWithinTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new EqualsWithin();
    }

    public function testTwoIntegersThatAreExactlyEqualWithZeroDelta()
    {
        $this->assert(123, equals, 123, within, 0);
    }
}
