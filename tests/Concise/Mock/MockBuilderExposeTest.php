<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockExpose
{
    protected function myMethod()
    {
        return 'abc';
    }

    protected function foo()
    {
        return 'bar';
    }
}

class MockBuilderExposeTest extends TestCase
{
    public function testExposeWillReturnSelfToAllowChaining()
    {
        $builder = $this->mock('\Concise\Mock\MockExpose');
        $this->assert($builder, equals, $builder->expose('myMethod'));
    }

    /**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Method Concise\Mock\MockExpose::baz() does not exist.
	 */
    public function testAnExceptionIsThrownIfTheMethodDoesNotExist()
    {
        $this->niceMock('\Concise\Mock\MockExpose')
             ->expose('baz')
             ->done();
    }

    public function testExposeTwoMethodsWithArraySyntax()
    {
        $mock = $this->niceMock('\Concise\Mock\MockExpose')
                     ->expose(array('myMethod', 'foo'))
                     ->done();
        $this->assert($mock->foo(), equals, 'bar');
    }
}
