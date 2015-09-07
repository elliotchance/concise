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
        $this->aassert(123)->equals(123);
    }

    public function testEqualsFloat()
    {
        $this->aassert(123)->equals(123.0);
    }

    public function testEqualsString()
    {
        $this->aassert(123)->equals("123");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testEqualsFailure()
    {
        $this->aassert(123)->equals(124);
    }

    public function testExactlyEquals()
    {
        $this->aassert(123)->exactlyEquals(123);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIntegerAndFloatWithTheSameValueAreNotExactlyEqual()
    {
        $this->aassert(123)->exactlyEquals(123.0);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIntegerAndItsStringRepresentationAreNotExactlyEqual()
    {
        $this->aassert(123)->exactlyEquals("123");
    }

    public function testIntegerAndFloatOfTheSameValueAreNotExactlyEqual()
    {
        $this->aassert(123)->isNotExactlyEqualTo(123.0);
    }

    public function testIntegerAndStringRepresentationOfTheSameValueAreNotExactlyEqual()
    {
        $this->aassert(123)->isNotExactlyEqualTo("123");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testNotExactlyEqualsFailure()
    {
        $this->aassert(123)->isNotExactlyEqualTo(123);
    }

    public function testNotEquals()
    {
        $this->aassert(123)->doesNotEqual(124);
    }

    public function testFloatingPointValuesThatDifferSlightlyAreNotEqual()
    {
        $this->aassert(123)->isNotEqualTo(123.000001);
    }
}
