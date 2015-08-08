<?php

namespace Concise\Modules\Types;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class IsInstanceOfTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsInstanceOf();
    }

    public function testIsInstanceOfWithSameClass()
    {
        $this->assert(
            new self(),
            is_an_instance_of,
            '\Concise\Modules\Types\IsInstanceOfTest'
        );
    }

    public function testIsInstanceOfWithSuperClass()
    {
        $this->assert(
            new self(),
            instance_of,
            '\Concise\Matcher\AbstractMatcherTestCase'
        );
    }

    public function testIsInstanceOfFailure()
    {
        $this->assertFailure(
            new \stdClass(),
            is_instance_of,
            '\Concise\Modules\Types\IsInstanceOfTest'
        );
    }

    public function testStringsRepresentingClassNamesCanBeUsed()
    {
        $this->assert(
            '\Concise\Modules\Types\IsInstanceOfTest',
            instance_of,
            '\Concise\TestCase'
        );
    }

    public function testIsInstanceOfWithSameClassNoPrefix()
    {
        $this->assert(
            new self(),
            is_an_instance_of,
            'Concise\Modules\Types\IsInstanceOfTest'
        );
    }
}
