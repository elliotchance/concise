<?php

namespace Concise\Mock;

use \Concise\TestCase;

interface MockInterface
{
    public function myMethod();
}

class MockBuilderInterfaceTest extends AbstractMockBuilderTestCase
{
    public function testNiceMockCanBeCreatedFromAnObjectThatExists()
    {
        $this->setExpectedException('\InvalidArgumentException', 'You cannot create a nice mock of an interface (\Concise\Mock\MockInterface).');
        parent::testNiceMockCanBeCreatedFromAnObjectThatExists();
    }

    public function testCallingMethodThatHasNoAssociatedActionOnANiceMockWillUseOriginal()
    {
        $this->setExpectedException('\InvalidArgumentException', 'You cannot create a nice mock of an interface (\Concise\Mock\MockInterface).');
        parent::testCallingMethodThatHasNoAssociatedActionOnANiceMockWillUseOriginal();
    }

    public function getClassName()
    {
        return '\Concise\Mock\MockInterface';
    }
}
