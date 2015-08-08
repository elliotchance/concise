<?php

namespace Concise\Modules\Booleans;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class IsFalseTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsFalse();
    }

    public function testFalse()
    {
        $this->assert(false, is_false);
    }

    public function testZeroIsNotFalse()
    {
        $this->assertFailure('0 is false');
    }

    public function testEmptyStringIsNotFalse()
    {
        $this->assertFailure('"" is false');
    }

    public function testFloatingZeroIsNotFalse()
    {
        $this->assertFailure('0.0 is false');
    }

    public function testFalseFailure()
    {
        $this->assertFailure(true, is_false);
    }
}
