<?php

namespace Concise\Mock;

use \Concise\TestCase;

final class MockFinalClass
{
}

class MockFinalClass2
{
    final public function myMethod()
    {
    }
}

class MockBuilderFinalClassTest extends TestCase
{
    /**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Class Concise\Mock\MockFinalClass is final so it cannot be mocked.
	 */
    public function testFinalClassesCannotBeMocked()
    {
        $this->mock('\Concise\Mock\MockFinalClass')
             ->done();
    }

    /**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Method Concise\Mock\MockFinalClass2::myMethod() is final so it cannot be mocked.
	 */
    public function testFinalMethodsCannotBeMocked()
    {
        $this->mock('\Concise\Mock\MockFinalClass2')
             ->stub('myMethod')
             ->done();
    }

    public function testFinalMethodsWillNotBeOverriddenInChildClasses()
    {
        $mock = $this->mock('\Concise\Mock\MockFinalClass2')
                     ->done();
        $this->assert($mock, instance_of, '\Concise\Mock\MockFinalClass2');
    }
}
