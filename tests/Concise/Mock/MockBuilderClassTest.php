<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockClass
{
    public function myMethod()
    {
        return 'abc';
    }
}

class MockBuilderClassTest extends AbstractMockBuilderTestCase
{
    public function getClassName()
    {
        return '\Concise\Mock\MockClass';
    }
}
