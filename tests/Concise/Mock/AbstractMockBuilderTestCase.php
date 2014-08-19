<?php

namespace Concise\Mock;

use \Concise\TestCase;

abstract class AbstractMockBuilderTestCase extends TestCase
{
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

    abstract public function getClassName();
}
