<?php

namespace Concise\Modules\Numbers;

use Concise\Matcher\AbstractNestedMatcherTestCase;
use Concise\Matcher\Tag;

/**
 * @group matcher
 */
class BetweenTest extends AbstractNestedMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new Between();
    }

    public function testNumberExistsBetweenTwoOtherNumbers()
    {
        $this->assert(123, between, 100, 'and', 150);
    }

    public function testNumberIsBelowLowerBounds()
    {
        $this->assertFailure(80, between, 100, 'and', 150);
    }

    public function testNumberIsOnTheLowerBound()
    {
        $this->assert(123, between, 123, 'and', 150);
    }

    public function testNumberIsAboveUpperBounds()
    {
        $this->assertFailure(170, between, 100, 'and', 150);
    }

    public function testNumberIsOnTheUpperBound()
    {
        $this->assert(150, between, 123, 'and', 150);
    }

    public function tags()
    {
        return array();
    }

    /**
     * @group #219
     */
    public function testNestedAssertionSuccess()
    {
        $this->assert(
            $this->assert(5, between, 0, 'and', 10),
            exactly_equals,
            5
        );
    }

    /**
     * @group #219
     */
    public function testNestedAssertionFailure()
    {
        $this->assertFailure(
            $this->assert(5, between, 0, 'and', 10),
            exactly_equals,
            6
        );
    }
}
