<?php

namespace Concise\Modules\Types;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class IsNotInstanceOfTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsNotInstanceOf();
    }

    public function testIsInstanceOfWithSameClass()
    {
        $this->assertFailure(
            new self(),
            is_not_an_instance_of,
            '\Concise\Modules\Types\IsNotInstanceOfTest'
        );
    }

    public function testIsInstanceOfWithSuperClass()
    {
        $this->assertFailure(
            new self(),
            not_instance_of,
            '\Concise\Matcher\AbstractMatcherTestCase'
        );
    }

    public function testIsInstanceOfFailure()
    {
        $this->assert(
            new \stdClass(),
            is_not_instance_of,
            '\Concise\Modules\Types\IsNotInstanceOfTest'
        );
    }

    public function testStringsRepresentingClassNamesCanBeUsed()
    {
        $this->assertFailure(
            '\Concise\Modules\Types\IsInstanceOfTest',
            is_not_instance_of,
            '\Concise\TestCase'
        );
    }
}
