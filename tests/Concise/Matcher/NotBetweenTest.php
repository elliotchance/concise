<?php

namespace Concise\Matcher;

class NotBetweenTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new NotBetween();
    }

    public function testNumberExistsBetweenTwoOtherNumbers()
    {
        $this->assertFailure(123, not_between, 100, 'and', 150);
    }

    public function testNumberIsBelowLowerBounds()
    {
        $this->assert(80, not_between, 100, 'and', 150);
    }

    public function testNumberIsOnTheLowerBound()
    {
        $this->assertFailure(123, not_between, 123, 'and', 150);
    }

    public function testNumberIsAboveUpperBounds()
    {
        $this->assert(170, not_between, 100, 'and', 150);
    }

    public function testNumberIsOnTheUpperBound()
    {
        $this->assertFailure(150, not_between, 123, 'and', 150);
    }
}
