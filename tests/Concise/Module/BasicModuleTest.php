<?php

namespace Concise\Module;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class BasicModuleTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new BasicModule();
    }

    public function comparisons()
    {
        return array(
            array('123 equals 123'),
            array('123 equals 123.0'),
            array('123 equals "123"'),
        );
    }

    /**
     * @dataProvider comparisons
     */
    public function testEquals($assertion)
    {
        $this->assert($assertion);
    }

    public function testEqualsFailure()
    {
        $this->assertFailure("123 equals 124");
    }

    public function testExactlyEquals()
    {
        $this->assert('123 exactly equals 123');
    }

    public function testIntegerAndFloatWithTheSameValueAreNotExactlyEqual()
    {
        $this->assertFailure('123 exactly equals 123.0');
    }

    public function testIntegerAndItsStringRepresentationAreNotExactlyEqual()
    {
        $this->assertFailure('123 exactly equals "123"');
    }

    public function testIntegerAndFloatOfTheSameValueAreNotExactlyEqual()
    {
        $this->assert('123 is not exactly equal to 123.0');
    }

    public function testIntegerAndStringRepresentationOfTheSameValueAreNotExactlyEqual()
    {
        $this->assert('123 is not exactly equal to "123"');
    }

    public function testNotExactlyEqualsFailure()
    {
        $this->assertFailure('123 is not exactly equal to 123');
    }

    public function testNotEquals()
    {
        $this->assert('123 does not equal 124');
    }

    public function testFloatingPointValuesThatDifferSlightlyAreNotEqual()
    {
        $this->assert('123 is not equal to 123.000001');
    }
}
