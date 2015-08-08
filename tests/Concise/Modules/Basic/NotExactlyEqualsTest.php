<?php

namespace Concise\Modules\Basic;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class NotExactlyEqualsTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new NotExactlyEquals();
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
}
