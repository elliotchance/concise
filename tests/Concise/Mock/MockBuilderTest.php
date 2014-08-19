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
        $this->mock('\Abc')->done();
    }

    public function testMockingAMethodThatDoesNotExistIfThereIsAMagicCallMethod()
    {
        $mock = $this->mock('\Concise\Mock\MockMagicCall')
                     ->stub('nothing')
                     ->done();
        $this->assert($mock->nothing(), is_null);
    }

    public function testNiceMockCanBeCreatedFromAClassThatExists()
    {
        $mock = $this->niceMock('\Concise\TestCase')
                     ->done();
        $this->assert($mock, instance_of, '\Concise\TestCase');
    }

    public function testCallingMethodThatHasNoAssociatedActionOnANiceMockWillUseOriginal()
    {
        $mock = $this->niceMock('\Concise\Mock\Mock1')
                     ->done();
        $this->assert($mock->myMethod(), equals, 'abc');
    }

    public function testMockClassDefaultsToStdClass()
    {
        $mock = $this->mock()
                     ->done();
        $this->assert($mock, instance_of, '\stdClass');
    }

    public function testNiceMockClassDefaultsToStdClass()
    {
        $mock = $this->niceMock()
                     ->done();
        $this->assert($mock, instance_of, '\stdClass');
    }
}
