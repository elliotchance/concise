<?php

namespace Concise\Mock;

use Concise\Core\TestCase;

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
    public function testNiceMocksWillCallConstructorByDefault()
    {
        $mock = $this->niceMock('\Concise\Mock\MockConstructor1')->get();
        $this->assert($mock->constructorRun)->isTrue;
    }

    public function testDisableConstructorCanBeChained()
    {
        $mock = $this->niceMock('\Concise\Mock\MockConstructor1')
            ->disableConstructor()
            ->get();
        $this->assert($mock)->isAnInstanceOf('\Concise\Mock\MockConstructor1');
    }

    public function testMocksCanHaveTheirConstructorDisabledWithArguments()
    {
        $mock = $this->niceMock('\Concise\Mock\MockConstructor2')
            ->disableConstructor()
            ->get();
        $this->assert($mock)->isAnInstanceOf('\Concise\Mock\MockConstructor2');
    }
}
