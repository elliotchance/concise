<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockPrivate
{
    private function myMethod()
    {
        return 'foo';
    }
}

/**
 * @group mocking
 */
class MockBuilderPrivateTest extends TestCase
{
    /**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Method Concise\Mock\MockPrivate::myMethod() cannot be mocked because it it private.
	 */
    public function testMockingPrivateMethodWillThrowException()
    {
        $this->mock('\Concise\Mock\MockPrivate')
             ->stub(array('myMethod' => 'bar'))
             ->get();
    }
}
