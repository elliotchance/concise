<?php

namespace Concise\Mock;

use \Concise\TestCase;

abstract class AbstractMockBuilderTestCase extends TestCase
{
    protected function notApplicable()
    {
        $this->markTestSkipped("This test is not applicable");
    }

    public function testMockCanBeCreatedFromAnObjectThatExists()
    {
        $mock = $this->mock($this->getClassName())
                     ->done();
        $this->assert($mock, instance_of, $this->getClassName());
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage myMethod() does not have an associated action - consider a niceMock()?
     */
    public function testCallingMethodThatHasNoAssociatedActionWillThrowAnException()
    {
        $mock = $this->mock($this->getClassName())
                     ->done();
        $mock->myMethod();
    }

    public function testNiceMockCanBeCreatedFromAnObjectThatExists()
    {
        $mock = $this->niceMock($this->getClassName())
                     ->done();
        $this->assert($mock, instance_of, $this->getClassName());
    }

    public function testCallingMethodThatHasNoAssociatedActionOnANiceMockWillUseOriginal()
    {
        $mock = $this->niceMock($this->getClassName())
                     ->done();
        $this->assert($mock->myMethod(), equals, 'abc');
    }

    abstract public function getClassName();

    // Constructor

    public function testMocksWillCallConstructorByDefault()
    {
        $mock = $this->mock($this->getClassName())
                     ->done();
        $this->assert($mock->constructorRun);
    }

    public function testMocksCanHaveTheirConstructorDisabled()
    {
        $mock = $this->mock('\Concise\Mock\MockConstructor1')
                     ->disableConstructor()
                     ->done();
        $this->assert($mock->constructorRun, is_false);
    }
}
