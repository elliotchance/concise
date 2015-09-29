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
        $this->module = new NumberModule();
    }

    public function testNumberExistsBetweenTwoOtherNumbers()
    {
        $this->assert(123)->isBetween(100)->and(150);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testNumberIsBelowLowerBounds()
    {
        $this->assert(80)->isBetween(100)->and(150);
    }

    public function testNumberIsOnTheLowerBound()
    {
        $this->assert(123)->isBetween(123)->and(150);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testNumberIsAboveUpperBounds()
    {
        $this->assert(170)->isBetween(100)->and(150);
    }

    public function testNumberIsOnTheUpperBound()
    {
        $this->assert(150)->isBetween(123)->and(150);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testTwoValuesThatAreExactlyEqualWithZeroDelta()
    {
        $this->assert(123.0)->isNotWithin(0)->of(123.0);
    }

    public function testTwoValuesThatAreNotEqualWithZeroDelta()
    {
        $this->assert(123.0)->isNotWithin(0.0)->of(124.0);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testComparingTwoValuesInsideTheDelta()
    {
        $this->assert(123.0)->isNotWithin(5.0)->of(125.0);
    }

    public function testComparingTwoValuesOutsideTheDelta()
    {
        $this->assert(123)->isNotWithin(5.0)->of(223);
    }

    public function testComparingTwoValuesOutsideTheDeltainReverse()
    {
        $this->assert(223)->isNotWithin(5.0)->of(123);
    }

    public function testTwoValuesThatAreExactlyEqualWithZeroDelta1()
    {
        $this->assert(123.0)->isWithin(0.0)->of(123.0);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testTwoValuesThatAreNotEqualWithZeroDelta1()
    {
        $this->assert(123.0)->isWithin(0.0)->of(124.0);
    }

    public function testComparingTwoValuesInsideTheDelta1()
    {
        $this->assert(123.0)->isWithin(5.0)->of(125.0);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testComparingTwoValuesOutsideTheDelta1()
    {
        $this->assert(123)->isWithin(5.0)->of(223);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testComparingTwoValuesOutsideTheDeltainReverse1()
    {
        $this->assert(223)->isWithin(5.0)->of(123);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testLessThan()
    {
        $this->assert(100)->isGreaterThanOrEqualTo(200);
    }

    public function testGreaterThanOrEqual()
    {
        $this->assert(200)->isGreaterThanOrEqualTo(200);
    }

    public function testGreaterThan()
    {
        /*$this->assert(300, is_greater_than_or_equal_to, 200);*/
        $this->assert(300)->isGreaterThanOrEqualTo(200);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testLessThan1()
    {
        $this->assert(100)->isGreaterThan(200);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testGreaterThanOrEqual1()
    {
        $this->assert(200)->isGreaterThan(200);
    }

    public function testGreaterThan1()
    {
        /*$this->assert(300, is_greater_than, 200);*/
        $this->assert(300)->isGreaterThan(200);
    }

    public function testLessThan2()
    {
        /*$this->assert(100, is_less_than, 200);*/
        $this->assert(100)->isLessThan(200);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testLessThanOrEqual()
    {
        $this->assert(200)->isLessThan(200);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testGreaterThan2()
    {
        $this->assert(300)->isLessThan(200);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testNumberExistsBetweenTwoOtherNumbers1()
    {
        $this->assert(123)->isNotBetween(100)->and(150);
    }

    public function testNumberIsBelowLowerBounds1()
    {
        $this->assert(80)->isNotBetween(100)->and(150);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testNumberIsOnTheLowerBound1()
    {
        $this->assert(123)->isNotBetween(123)->and(150);
    }

    public function testNumberIsAboveUpperBounds1()
    {
        $this->assert(170)->isNotBetween(100)->and(150);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testNumberIsOnTheUpperBound1()
    {
        $this->assert(150)->isNotBetween(123)->and(150);
    }

    public function testLessThan3()
    {
        $this->assert(100)->isLessThanOrEqualTo(200);
    }

    public function testLessThanOrEqual1()
    {
        $this->assert(200)->isLessThanOrEqualTo(200);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testGreaterThan3()
    {
        $this->assert(300)->isLessThanOrEqualTo(200);
    }
}
