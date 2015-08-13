<?php

namespace Concise\Modules\Booleans;

use Concise\Matcher\AbstractMatcherTestCase;
use Concise\Modules\BooleanModule;

/**
 * @group matcher
 */
class BooleanModuleTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new BooleanModule();
    }

    public function testAlwaysFails()
    {
        $this->assertFailure('false');
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

    public function testFalseIsFalsy()
    {
        $this->assert(false, is_falsy);
    }

    public function testTrueIsNotFalsy()
    {
        $this->assertFailure(true, is_falsy);
    }

    public function testZeroIsFalsy()
    {
        $this->assert(0, is_falsy);
    }

    public function testIsTrue()
    {
        $this->assert(true, is_true);
    }

    public function testIsTrueFailure()
    {
        $this->assertFailure('123 is true');
    }

    public function testOneIsNotTrue()
    {
        $this->assertFailure('1 is true');
    }

    public function testFalseIsNotTruthy()
    {
        $this->assertFailure(false, is_truthy);
    }

    public function testTrueIsTruthy()
    {
        $this->assert(true, is_truthy);
    }

    public function testOneIsTruthy()
    {
        $this->assert(1, is_truthy);
    }

    public function testTrue()
    {
        $this->assert('true');
    }
}
