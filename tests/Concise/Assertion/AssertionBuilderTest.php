<?php

namespace Concise\Assertion;

use Concise\TestCase;

class AssertionBuilderTest extends TestCase
{
    public function testAssertionDataWithOneElement()
    {
        $builder = new AssertionBuilder(123);
        $this->assert($builder->getData(), equals, array(123));
    }
}
