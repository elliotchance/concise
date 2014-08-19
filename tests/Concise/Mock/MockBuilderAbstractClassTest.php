<?php

namespace Concise\Mock;

abstract class MockAbstractClass
{
    public function myMethod()
    {
        return 'abc';
    }
}

class MockBuilderAbstractClassTest extends AbstractMockBuilderTestCase
{
    public function getClassName()
    {
        return '\Concise\Mock\MockAbstractClass';
    }
}
