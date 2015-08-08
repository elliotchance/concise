<?php

namespace Concise\Modules\Types;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class IsAnIntegerTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsAnInteger();
    }

    public function testIntegerIsAnInteger()
    {
        $this->assert('123 is an integer');
    }

    public function testFloatIsNotAnInteger()
    {
        $this->assertFailure('123.0 is an integer');
    }

    public function testStringThatRepresentsAnIntegerIsNotAnInteger()
    {
        $this->assertFailure('"123" is an integer');
    }
}
