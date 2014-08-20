<?php

namespace Concise\Mock;

use \Concise\TestCase;

interface MockInterface
{
    public function myMethod();
}

class MockBuilderForInterfaceTest extends AbstractMockBuilderTestCase
{
    public function testNiceMockCanBeCreatedFromAnObjectThatExists()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockInterface).');
        parent::testNiceMockCanBeCreatedFromAnObjectThatExists();
    }

    public function testCallingMethodThatHasNoAssociatedActionOnANiceMockWillUseOriginal()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockInterface).');
        parent::testCallingMethodThatHasNoAssociatedActionOnANiceMockWillUseOriginal();
    }

    public function testMockReceivesConstructorArguments()
    {
        $this->notApplicable();
    }

    public function testMocksCanHaveTheirConstructorDisabled()
    {
        $this->expectFailure('You cannot disable the constructor of an interface (\Concise\Mock\MockInterface).');
        parent::testMocksCanHaveTheirConstructorDisabled();
    }

    public function getClassName()
    {
        return '\Concise\Mock\MockInterface';
    }
}
