<?php

namespace Concise\Mock;

use Concise\Core\TestCase;

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

/**
 * @group mocking
 */
class MockBuilderExposeTest extends TestCase
{
    public function testExposeWillReturnSelfToAllowChaining()
    {
        $builder = $this->niceMock('\Concise\Mock\MockExpose');
        $this->assert($builder)->equals($builder->expose('myMethod'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Method Concise\Mock\MockExpose::baz() does not
     *     exist.
     */
    public function testAnExceptionIsThrownIfTheMethodDoesNotExist()
    {
        $this->niceMock('\Concise\Mock\MockExpose')->expose('baz')->get();
    }
}
