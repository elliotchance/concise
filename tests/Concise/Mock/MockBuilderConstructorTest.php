<?php

namespace Concise\Mock;

use Concise\TestCase;

class MockConstructor1
{
    public $constructorRun = false;

    public function __construct()
    {
        $this->constructorRun = true;
    }
}

class MockConstructor2
{
    public function __construct($abc)
    {
    }
}

class Mock3
{
    public function __construct($a)
    {
    }
}

/**
 * @group mocking
 */
class MockBuilderConstructorTest extends TestCase
{
    public function testMocksWillCallConstructorByDefault()
    {
        $mock = $this->mock('\Concise\Mock\MockConstructor1')->get();
        $this->assert($mock->constructorRun);
    }

    public function testDisableConstructorCanBeChained()
    {
        $mock = $this->mock('\Concise\Mock\MockConstructor1')
            ->disableConstructor()
            ->get();
        $this->assert($mock, instance_of, '\Concise\Mock\MockConstructor1');
    }

    public function testMocksCanHaveTheirConstructorDisabledWithArguments()
    {
        $mock = $this->mock('\Concise\Mock\MockConstructor2')
            ->disableConstructor()
            ->get();
        $this->assert($mock, instance_of, '\Concise\Mock\MockConstructor2');
    }
}
