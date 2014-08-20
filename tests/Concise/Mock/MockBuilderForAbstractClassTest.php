<?php

namespace Concise\Mock;

abstract class MockAbstractClass
{
    public $constructorRun = false;

    public function __construct($a, $b)
    {
        $this->constructorRun = $b;
    }

    public function myMethod()
    {
        return 'abc';
    }
}

class MockBuilderForAbstractClassTest extends AbstractMockBuilderTestCase
{
    public function getClassName()
    {
        return '\Concise\Mock\MockAbstractClass';
    }
}
