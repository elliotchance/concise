<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockBuilderDoTest extends TestCase
{
    public function testTheCallbackWillBeExecuted()
    {
        $a = 123;
        $mock = $this->mock('\Concise\Mock\Mock1')
            ->stub('myMethod')->andDo(function () use (&$a) {
                $a = 456;
            })
            ->done();
        $mock->myMethod();
        $this->assert($a, equals, 456);
    }

    public function testTheCallbackWillNotBeExecutedIfNotCalled()
    {
        $a = 123;
        $mock = $this->mock('\Concise\Mock\Mock1')
            ->stub('myMethod')->andDo(function () use (&$a) {
                $a = 456;
            })
            ->done();
        $this->assert($a, equals, 123);
    }
}
