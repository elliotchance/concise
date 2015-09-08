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

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testAlwaysFails()
    {
        $this->aassertFalse();
    }

    public function testFalse()
    {
        $this->aassert(false)->isFalse;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testZeroIsNotFalse()
    {
        $this->aassert(0)->isFalse;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testEmptyStringIsNotFalse()
    {
        $this->aassert("")->isFalse;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFloatingZeroIsNotFalse()
    {
        $this->aassert(0.0)->isFalse;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFalseFailure()
    {
        $this->aassert(true)->isFalse;
    }

    public function testFalseIsFalsy()
    {
        $this->aassert(false)->isFalsy;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testTrueIsNotFalsy()
    {
        $this->aassert(true)->isFalse;
    }

    public function testZeroIsFalsy()
    {
        $this->aassert(0)->isFalsy;
    }

    public function testIsTrue()
    {
        $this->aassert(true)->isTrue;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsTrueFailure()
    {
        $this->aassert(123)->isTrue;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testOneIsNotTrue()
    {
        $this->aassert(1)->isTrue;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFalseIsNotTruthy()
    {
        $this->aassert(false)->isTruthy;
    }

    public function testTrueIsTruthy()
    {
        $this->aassert(true)->isTruthy;
    }

    public function testOneIsTruthy()
    {
        $this->aassert(1)->isTruthy;
    }

    public function testTrue()
    {
        $this->aassertTrue();
    }
}
