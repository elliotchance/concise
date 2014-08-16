<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockBuilderDoTest extends TestCase
{
    public function testACallbackCanBeSet()
    {
        $mock = $this->mock('\Concise\Mock\Mock1')
                     ->stub('myMethod')->andDo(function () {})
                     ->done();
        $this->assert($mock->myMethod(), equals, null);
    }
}
