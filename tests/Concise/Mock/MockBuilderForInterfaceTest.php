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
    public function testNiceMockReceivesConstructorArguments()
    {
        $this->notApplicable();
    }

    public function getClassName()
    {
        return '\Concise\Mock\MockedInterface';
    }

    public function testExposeASingleMethod()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testExposeASingleMethod();
    }

    public function testAnExceptionIsThrownIfTheMethodDoesNotExist()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testAnExceptionIsThrownIfTheMethodDoesNotExist();
    }

    public function testExposeTwoMethodsWithSeparateParameters()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testExposeTwoMethodsWithSeparateParameters();
    }

    public function testExposeTwoMethodsByCallingExposeTwice()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testExposeTwoMethodsByCallingExposeTwice();
    }

    public function testExposeTwoMethodsWithArraySyntax()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testExposeTwoMethodsWithArraySyntax();
    }

    public function testMockingPrivateMethodWillThrowException()
    {
        $this->expectFailure('Method Concise\Mock\MockedInterface::myPrivateMethod() does not exist.');
        parent::testMockingPrivateMethodWillThrowException();
    }

    public function testCallingMethodOnNiceMockWithStub()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testCallingMethodOnNiceMockWithStub();
    }

    public function testMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate()
    {
        $this->notApplicable();
    }

    public function testNiceMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testNiceMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate();
    }

    public function testCallingAnAbstractMethodOnANiceMockWithNoRuleThrowsException()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testCallingAnAbstractMethodOnANiceMockWithNoRuleThrowsException();
    }

    public function testFinalMethodsCanNotBeMocked()
    {
        $this->notApplicable();
    }

    public function testCallingAnAbstractMethodWithNoRuleThrowsException()
    {
        $this->expectFailure('myAbstractMethod() is abstract and has no associated action.', '\Exception');
        parent::testCallingAnAbstractMethodWithNoRuleThrowsException();
    }

    public function testAReturnPropertyCanBeSet()
    {
        $this->expectFailure('You cannot return a property from an interface (\Concise\Mock\MockedInterface).');
        parent::testAReturnPropertyCanBeSet();
    }

    public function testAnExceptionIsThrownIfPropertyDoesNotExistAtRuntime()
    {
        $this->expectFailure('You cannot return a property from an interface (\Concise\Mock\MockedInterface).');
        parent::testAnExceptionIsThrownIfPropertyDoesNotExistAtRuntime();
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

    public function testStubbingMultipleMethodsWithMultipleArguments()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testStubbingMultipleMethodsWithMultipleArguments();
    }

    public function testFirstMethodOfMultipleStubsReceivesAction()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testFirstMethodOfMultipleStubsReceivesAction();
    }

    public function testSecondMethodOfMultipleStubsReceivesAction()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testSecondMethodOfMultipleStubsReceivesAction();
    }

    public function testMultipleWithsNotBeingFullfilled()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testMultipleWithsNotBeingFullfilled();
    }

    public function testMultipleWithsNotBeingFullfilledInDifferentOrder()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testMultipleWithsNotBeingFullfilledInDifferentOrder();
    }

    /**
     * @group #182
     */
    public function testSetAPrivatePropertyOnAMockWillSetThePropertyOnTheNonMockedClass()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockedInterface).');
        parent::testSetAPrivatePropertyOnAMockWillSetThePropertyOnTheNonMockedClass();
    }
}
