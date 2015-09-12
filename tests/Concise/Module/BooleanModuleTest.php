<?php

namespace Concise\Module;

/**
 * @group matcher
 */
class BooleanModuleTest extends AbstractModuleTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new BooleanModule();
    }

    public function testFalse()
    {
        $this->assert(false)->isFalse;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testZeroIsNotFalse()
    {
        $this->assert(0)->isFalse;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testEmptyStringIsNotFalse()
    {
        $this->assert("")->isFalse;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFloatingZeroIsNotFalse()
    {
        $this->assert(0.0)->isFalse;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFalseFailure()
    {
        $this->assert(true)->isFalse;
    }

    public function testFalseIsFalsy()
    {
        $this->assert(false)->isFalsy;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testTrueIsNotFalsy()
    {
        $this->assert(true)->isFalse;
    }

    public function testZeroIsFalsy()
    {
        $this->assert(0)->isFalsy;
    }

    public function testIsTrue()
    {
        $this->assert(true)->isTrue;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsTrueFailure()
    {
        $this->assert(123)->isTrue;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testOneIsNotTrue()
    {
        $this->assert(1)->isTrue;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFalseIsNotTruthy()
    {
        $this->assert(false)->isTruthy;
    }

    public function testTrueIsTruthy()
    {
        $this->assert(true)->isTruthy;
    }

    public function testOneIsTruthy()
    {
        $this->assert(1)->isTruthy;
    }
}
