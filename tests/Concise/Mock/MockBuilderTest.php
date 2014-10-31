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

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 2
     */
    public function testClassNameMustBeAString()
    {
        $this->mock(123);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected boolean, but got integer for argument 3
     */
    public function testNiceMockMustBeABoolean()
    {
        new MockBuilder($this, 'stdClass', 123);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testExpectMustBeAString()
    {
        $mock = new MockBuilder($this, 'stdClass', true);
        $mock->expect(123);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected integer, but got string for argument 1
     */
    public function testExactlyMustBeAnInteger()
    {
        $mock = new MockBuilder($this, 'stdClass', true);
        $mock->exactly('foo');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testSetCustomClassNameMustBeAString()
    {
        $mock = new MockBuilder($this, 'stdClass', true);
        $mock->setCustomClassName(123);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testAndReturnPropertyMustBeAString()
    {
        $mock = new MockBuilder($this, 'stdClass', true);
        $mock->andReturnProperty(123);
    }
}
