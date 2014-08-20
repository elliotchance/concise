<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockClass
{
    public $constructorRun = false;

    public function __construct($a, $b)
    {
        $this->constructorRun = true;
    }

    public function myMethod()
    {
        return 'abc';
    }

    protected function mySecretMethod()
    {
        return 'abc';
    }
}

class MockBuilderForClassTest extends AbstractMockBuilderTestCase
{
    public function getClassName()
    {
        return '\Concise\Mock\MockClass';
    }
}
