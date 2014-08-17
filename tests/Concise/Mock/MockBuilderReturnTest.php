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
}
