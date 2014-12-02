<?php

namespace Concise\Mock;

interface MockedInterface
{
    public function myMethod();

    public function mySecondMethod();

    public static function myStaticMethod();

    public function myWithMethod($a);

    public function myAbstractMethod();
}

/**
 * @group mocking
 */
class MockBuilderForInterfaceTest extends AbstractMockBuilderTestCase
{
    public function getClassName()
    {
        return '\Concise\Mock\MockedInterface';
    }

    public function testMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate()
    {
        $this->notApplicable();
    }

    public function testFinalMethodsCanNotBeMocked()
    {
        $this->notApplicable();
    }

    public function testGetAProtectedProperty()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testGetAProtectedProperty();
    }

    public function testSetAProtectedProperty()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testSetAProtectedProperty();
    }

    public function testSetAPrivatePropertyOnAMockWillSetThePropertyOnTheNonMockedClass()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testSetAPrivatePropertyOnAMockWillSetThePropertyOnTheNonMockedClass();
    }
}
