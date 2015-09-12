<?php

namespace Concise\Module;

/**
 * @group matcher
 */
class BasicModuleTest extends AbstractModuleTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new BasicModule();
    }

    public function testEqualsInt()
    {
        $this->assert(123)->equals(123);
    }

    public function testEqualsFloat()
    {
        $this->assert(123)->equals(123.0);
    }

    public function testEqualsString()
    {
        $this->assert(123)->equals("123");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testEqualsFailure()
    {
        $this->assert(123)->equals(124);
    }

    public function testExactlyEquals()
    {
        $this->assert(123)->exactlyEquals(123);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIntegerAndFloatWithTheSameValueAreNotExactlyEqual()
    {
        $this->assert(123)->exactlyEquals(123.0);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIntegerAndItsStringRepresentationAreNotExactlyEqual()
    {
        $this->assert(123)->exactlyEquals("123");
    }

    public function testIntegerAndFloatOfTheSameValueAreNotExactlyEqual()
    {
        $this->assert(123)->isNotExactlyEqualTo(123.0);
    }

    public function testIntegerAndStringRepresentationOfTheSameValueAreNotExactlyEqual()
    {
        $this->assert(123)->isNotExactlyEqualTo("123");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testNotExactlyEqualsFailure()
    {
        $this->assert(123)->isNotExactlyEqualTo(123);
    }

    public function testNotEquals()
    {
        $this->assert(123)->doesNotEqual(124);
    }

    public function testFloatingPointValuesThatDifferSlightlyAreNotEqual()
    {
        $this->assert(123)->isNotEqualTo(123.000001);
    }
}
