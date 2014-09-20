<?php

namespace Concise\Mock;

use \Concise\TestCase;

abstract class Mock2
{
    abstract public function foo();

    public function bar()
    {
        return 123;
    }
}

class MockMagicCall
{
    public function __call($name, $arguments)
    {
        return 'foo';
    }
}

class MockBuilderTest extends TestCase
{
    /**
	 * @expectedException Exception
	 * @expectedExceptionMessage Class or interface '\Abc' does not exist.
	 */
    public function testExceptionIsThrownIfTheClassTryingToBeMockedDoesNotExist()
    {
        $this->mock('\Abc')->get();
    }

    public function testMockingAMethodThatDoesNotExistIfThereIsAMagicCallMethod()
    {
        $mock = $this->mock('\Concise\Mock\MockMagicCall')
                     ->stub('nothing')
                     ->get();
        $this->assert($mock->nothing(), is_null);
    }

    public function testMockClassDefaultsToStdClass()
    {
        $mock = $this->mock()
                     ->get();
        $this->assert($mock, instance_of, '\stdClass');
    }

    public function testNiceMockClassDefaultsToStdClass()
    {
        $mock = $this->niceMock()
                     ->get();
        $this->assert($mock, instance_of, '\stdClass');
    }
}
