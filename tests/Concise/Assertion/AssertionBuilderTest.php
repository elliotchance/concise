<?php

namespace Concise\Assertion;

use Concise\TestCase;

class AssertionBuilderTest extends TestCase
{
    public function testDataWithOneElement()
    {
        $builder = new AssertionBuilder(123);
        $this->assert($builder->getData(), equals, array(123));
    }

    public function testEmptySyntax()
    {
        $builder = new AssertionBuilder(123);
        $this->assert($builder->getSyntax(), equals, '?');
    }
}
