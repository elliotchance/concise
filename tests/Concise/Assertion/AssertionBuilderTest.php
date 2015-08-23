<?php

namespace Concise\Assertion;

use Concise\TestCase;

class AssertionBuilderTest extends TestCase
{
    public function testAssertionBuilderWithAValueCanBeConvertedToAString()
    {
        $builder = new AssertionBuilder(123);
        $this->assert((string)$builder, equals, "123");
    }
}
