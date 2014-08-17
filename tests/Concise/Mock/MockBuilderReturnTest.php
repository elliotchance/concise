<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockBuilderReturnTest extends TestCase
{
    public function testAndReturnWithASingleArgument()
    {
        $mock = $this->mock('\Concise\Mock\Mock1')
                     ->stub('myMethod')->andReturn('foo')
                     ->done();
        $this->assert($mock->myMethod(), equals, 'foo');
    }

    public function testAndReturnCanTakeMultipleArguments()
    {
        $mock = $this->mock('\Concise\Mock\Mock1')
                     ->stub('myMethod')->andReturn('foo', 'bar')
                     ->done();
        $this->assert($mock->myMethod(), equals, 'foo');
    }

    public function testAndReturnWithMultipleArgumentsCanBeCalledWithDifferentResults()
    {
        $mock = $this->mock('\Concise\Mock\Mock1')
                     ->stub('myMethod')->andReturn('foo', 'bar')
                     ->done();
        $mock->myMethod();
        $this->assert($mock->myMethod(), equals, 'bar');
    }

    public function testAndReturnWithASingleArgumentWillAlwaysReturnThatValue()
    {
        $mock = $this->mock('\Concise\Mock\Mock1')
                     ->stub('myMethod')->andReturn('foo')
                     ->done();
        $mock->myMethod();
        $mock->myMethod();
        $this->assert($mock->myMethod(), equals, 'foo');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Only 2 return values have been provided.
     */
    public function testAndReturnWithMultipleArgumentsCanNotBeCalledMoreTimesThatReturnValues()
    {
        $mock = $this->mock('\Concise\Mock\Mock1')
                     ->stub('myMethod')->andReturn('foo', 'bar')
                     ->done();
        $mock->myMethod();
        $mock->myMethod();
        $mock->myMethod();
    }
}
