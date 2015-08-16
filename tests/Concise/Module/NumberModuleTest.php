<?php

namespace Concise\Module;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class NumberModuleTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new NumberModule();
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

    public function testTwoValuesThatAreExactlyEqualWithZeroDelta1()
    {
        $this->assert(123.0, equals, 123.0, within, 0.0);
    }

    public function testTwoValuesThatAreNotEqualWithZeroDelta1()
    {
        $this->assertFailure(123.0, equals, 124.0, within, 0.0);
    }

    public function testComparingTwoValuesInsideTheDelta1()
    {
        $this->assert(123.0, equals, 125.0, within, 5.0);
    }

    public function testComparingTwoValuesOutsideTheDelta1()
    {
        $this->assertFailure(123, equals, 223, within, 5.0);
    }

    public function testComparingTwoValuesOutsideTheDeltainReverse1()
    {
        $this->assertFailure(223, equals, 123, within, 5.0);
    }

    public function testLessThan()
    {
        $this->assertFailure(100, is_greater_than_or_equal_to, 200);
    }

    public function testGreaterThanOrEqual()
    {
        $this->assert(200, is_greater_than_or_equal_to, 200);
    }

    public function testGreaterThan()
    {
        $this->assert(300, is_greater_than_or_equal_to, 200);
    }

    public function testLessThan1()
    {
        $this->assertFailure(100, is_greater_than, 200);
    }

    public function testGreaterThanOrEqual1()
    {
        $this->assertFailure(200, is_greater_than, 200);
    }

    public function testGreaterThan1()
    {
        $this->assert(300, is_greater_than, 200);
    }

    public function testLessThan2()
    {
        $this->assert(100, is_less_than, 200);
    }

    public function testLessThanOrEqual()
    {
        $this->assertFailure(200, is_less_than, 200);
    }

    public function testGreaterThan2()
    {
        $this->assertFailure(300, is_less_than, 200);
    }

    public function testNumberExistsBetweenTwoOtherNumbers1()
    {
        $this->assertFailure(123, not_between, 100, 'and', 150);
    }

    public function testNumberIsBelowLowerBounds1()
    {
        $this->assert(80, not_between, 100, 'and', 150);
    }

    public function testNumberIsOnTheLowerBound1()
    {
        $this->assertFailure(123, not_between, 123, 'and', 150);
    }

    public function testNumberIsAboveUpperBounds1()
    {
        $this->assert(170, not_between, 100, 'and', 150);
    }

    public function testNumberIsOnTheUpperBound1()
    {
        $this->assertFailure(150, not_between, 123, 'and', 150);
    }

    public function testLessThan3()
    {
        $this->assert(100, is_less_than_or_equal_to, 200);
    }

    public function testLessThanOrEqual1()
    {
        $this->assert(200, is_less_than_or_equal_to, 200);
    }

    public function testGreaterThan3()
    {
        $this->assertFailure(300, is_less_than_or_equal_to, 200);
    }
}
