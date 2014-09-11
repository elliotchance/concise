<?php

namespace Concise\Mock;

interface MockInterface
{
    public function myMethod();

    public function mySecondMethod();

    public static function myStaticMethod();

    public function myWithMethod($a);

    public function myAbstractMethod();
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

    public function testNiceMockReceivesConstructorArguments()
    {
        $this->notApplicable();
    }

    public function getClassName()
    {
        return '\Concise\Mock\MockInterface';
    }

    public function testExposeASingleMethod()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockInterface).');
        parent::testExposeASingleMethod();
    }

    public function testAnExceptionIsThrownIfTheMethodDoesNotExist()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockInterface).');
        parent::testAnExceptionIsThrownIfTheMethodDoesNotExist();
    }

    public function testExposeTwoMethodsWithSeparateParameters()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockInterface).');
        parent::testExposeTwoMethodsWithSeparateParameters();
    }

    public function testExposeTwoMethodsByCallingExposeTwice()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockInterface).');
        parent::testExposeTwoMethodsByCallingExposeTwice();
    }

    public function testExposeTwoMethodsWithArraySyntax()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockInterface).');
        parent::testExposeTwoMethodsWithArraySyntax();
    }

    public function testMockingPrivateMethodWillThrowException()
    {
        $this->expectFailure('Method Concise\Mock\MockInterface::myPrivateMethod() does not exist.');
        parent::testMockingPrivateMethodWillThrowException();
    }

    public function testCallingMethodOnNiceMockWithStub()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockInterface).');
        parent::testCallingMethodOnNiceMockWithStub();
    }

    public function testMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate()
    {
        $this->notApplicable();
    }

    public function testNiceMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockInterface).');
        parent::testNiceMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate();
    }

    public function testCallingAnAbstractMethodOnANiceMockWithNoRuleThrowsException()
    {
        $this->expectFailure('You cannot create a nice mock of an interface (\Concise\Mock\MockInterface).');
        parent::testCallingAnAbstractMethodOnANiceMockWithNoRuleThrowsException();
    }

    public function testFinalMethodsCanNotBeMocked()
    {
        $this->notApplicable();
    }

    public function testCallingMethodThatHasNoAssociatedActionWillThrowAnException()
    {
        $this->expectFailure('myMethod() is abstract and has no associated action.', '\Exception');
        parent::testCallingMethodThatHasNoAssociatedActionWillThrowAnException();
    }

    public function testCallingAnAbstractMethodWithNoRuleThrowsException()
    {
        $this->expectFailure('myAbstractMethod() is abstract and has no associated action.', '\Exception');
        parent::testCallingAnAbstractMethodWithNoRuleThrowsException();
    }
}
