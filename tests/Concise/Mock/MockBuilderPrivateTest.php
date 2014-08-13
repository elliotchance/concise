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

class MockBuilderPrivateTest extends TestCase
{
    /**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Method 'myMethod' cannot be mocked becuase it it private.
	 */
    public function testMockingPrivateMethodWillThrowException()
    {
        $this->mock('\Concise\Mock\MockPrivate')
             ->stub(array('myMethod' => 'bar'))
             ->done();
    }
}
