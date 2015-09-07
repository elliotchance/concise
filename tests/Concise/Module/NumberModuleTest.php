<?php

namespace Concise\Module;

/**
 * @group matcher
 */
class NumberModuleTest extends AbstractModuleTestCase
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

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testNumberIsBelowLowerBounds()
    {
        $this->aassert(80)->between(100)->and(150);
    }

    public function testNumberIsOnTheLowerBound()
    {
        $this->assert(123, between, 123, 'and', 150);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testNumberIsAboveUpperBounds()
    {
        $this->aassert(170)->between(100)->and(150);
    }

    public function testNumberIsOnTheUpperBound()
    {
        $this->assert(150, between, 123, 'and', 150);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testTwoValuesThatAreExactlyEqualWithZeroDelta()
    {
            $this->aassert(123.0)->isNotWithin(0)->of(123.0);
    }

    public function testTwoValuesThatAreNotEqualWithZeroDelta()
    {
        $this->aassert(123.0)->isNotWithin(0.0)->of(124.0);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testComparingTwoValuesInsideTheDelta()
    {
            $this->aassert(123.0)->isNotWithin(5.0)->of(125.0);
    }

    public function testComparingTwoValuesOutsideTheDelta()
    {
        $this->aassert(123)->isNotWithin(5.0)->of(223);
    }

    public function testComparingTwoValuesOutsideTheDeltainReverse()
    {
        $this->aassert(223)->isNotWithin(5.0)->of(123);
    }

    public function testTwoValuesThatAreExactlyEqualWithZeroDelta1()
    {
        $this->aassert(123.0)->isWithin(0.0)->of(123.0);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testTwoValuesThatAreNotEqualWithZeroDelta1()
    {
            $this->aassert(123.0)->isWithin(0.0)->of(124.0);
    }

    public function testComparingTwoValuesInsideTheDelta1()
    {
        $this->aassert(123.0)->isWithin(5.0)->of(125.0);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testComparingTwoValuesOutsideTheDelta1()
    {
            $this->aassert(123)->isWithin(5.0)->of(223);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testComparingTwoValuesOutsideTheDeltainReverse1()
    {
            $this->aassert(223)->isWithin(5.0)->of(123);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testLessThan()
    {
        $this->aassert(100)->isGreaterThanOrEqualTo(200);
    }

    public function testGreaterThanOrEqual()
    {
        $this->aassert(200)->isGreaterThanOrEqualTo(200);
    }

    public function testGreaterThan()
    {
        $this->assert(300, is_greater_than_or_equal_to, 200);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testLessThan1()
    {
        $this->aassert(100)->isGreaterThan(200);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testGreaterThanOrEqual1()
    {
        $this->aassert(200)->isGreaterThan(200);
    }

    public function testGreaterThan1()
    {
        $this->assert(300, is_greater_than, 200);
    }

    public function testLessThan2()
    {
        $this->assert(100, is_less_than, 200);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testLessThanOrEqual()
    {
        $this->aassert(200)->isLessThan(200);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testGreaterThan2()
    {
        $this->aassert(300)->isLessThan(200);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testNumberExistsBetweenTwoOtherNumbers1()
    {
        $this->aassert(123)->notBetween(100)->and(150);
    }

    public function testNumberIsBelowLowerBounds1()
    {
        $this->aassert(80)->notBetween(100)->and(150);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testNumberIsOnTheLowerBound1()
    {
        $this->aassert(123)->notBetween(123)->and(150);
    }

    public function testNumberIsAboveUpperBounds1()
    {
        $this->aassert(170)->notBetween(100)->and(150);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testNumberIsOnTheUpperBound1()
    {
        $this->aassert(150)->notBetween(123)->and(150);
    }

    public function testLessThan3()
    {
        $this->assert(100, is_less_than_or_equal_to, 200);
    }

    public function testLessThanOrEqual1()
    {
        $this->assert(200, is_less_than_or_equal_to, 200);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testGreaterThan3()
    {
        $this->aassert(300)->isLessThanOrEqualTo(200);
    }
}
