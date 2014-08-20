<?php

namespace Concise\Mock;

use \Concise\TestCase;

final class MockFinalClass
{
    public $constructorRun = false;

    public function __construct($a, $b)
    {
        $this->constructorRun = true;
    }

    public function myMethod()
    {
        return 'abc';
    }

    protected function mySecretMethod()
    {
        return 'abc';
    }

    public function mySecondMethod()
    {
        return 'bar';
    }

    private function myPrivateMethod()
    {
    }
}

class MockFinalClass2
{
    final public function myMethod()
    {
    }
}

class MockBuilderForFinalClassTest extends AbstractMockBuilderTestCase
{
    public function getClassName()
    {
        return '\Concise\Mock\MockFinalClass';
    }

    public function testFinalMethodsWillNotBeOverriddenInChildClasses()
    {
        $mock = $this->mock('\Concise\Mock\MockFinalClass2')
                     ->done();
        $this->assert($mock, instance_of, '\Concise\Mock\MockFinalClass2');
    }

    public function testMockCanBeCreatedFromAnObjectThatExists()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMockCanBeCreatedFromAnObjectThatExists();
    }

    public function testCallingMethodThatHasNoAssociatedActionWillThrowAnException()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testCallingMethodThatHasNoAssociatedActionWillThrowAnException();
    }

    public function testNiceMockCanBeCreatedFromAnObjectThatExists()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testNiceMockCanBeCreatedFromAnObjectThatExists();
    }

    public function testCallingMethodThatHasNoAssociatedActionOnANiceMockWillUseOriginal()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testCallingMethodThatHasNoAssociatedActionOnANiceMockWillUseOriginal();
    }

    public function testMocksCanHaveTheirConstructorDisabled()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMocksCanHaveTheirConstructorDisabled();
    }

    public function testMockReceivesConstructorArguments()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMockReceivesConstructorArguments();
    }

    public function testNiceMockReceivesConstructorArguments()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testNiceMockReceivesConstructorArguments();
    }

    public function testACallbackCanBeSet()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testACallbackCanBeSet();
    }

    public function testTheCallbackWillBeExecuted()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testTheCallbackWillBeExecuted();
    }

    public function testTheCallbackWillNotBeExecutedIfNotCalled()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testTheCallbackWillNotBeExecutedIfNotCalled();
    }

    public function testCanCreateAnExpectation()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testCanCreateAnExpectation();
    }

    public function testCanCreateAnExpectationOfTwice()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testCanCreateAnExpectationOfTwice();
    }

    public function testWeDoNotNeedToSpecifyAnActionForAnExpectationWeNeverWantToHappen()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testWeDoNotNeedToSpecifyAnActionForAnExpectationWeNeverWantToHappen();
    }

    public function testCanCreateAnExpectationOfASpecificAmountOfTimes()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testCanCreateAnExpectationOfASpecificAmountOfTimes();
    }

    public function testExactlyZeroIsTheSameAsNever()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testExactlyZeroIsTheSameAsNever();
    }

    public function testDefaultExpectationIsOnce()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testDefaultExpectationIsOnce();
    }

    public function testCanCreateAnExpectationWithArgumentValues()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testCanCreateAnExpectationWithArgumentValues();
    }

    public function testCanUseExpectsInsteadOfExpect()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testCanUseExpectsInsteadOfExpect();
    }

    public function testExposeASingleMethod()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testExposeASingleMethod();
    }

    public function testExposeTwoMethodsWithSeparateParameters()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testExposeTwoMethodsWithSeparateParameters();
    }

    public function testExposeTwoMethodsByCallingExposeTwice()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testExposeTwoMethodsByCallingExposeTwice();
    }

    public function testExposeTwoMethodsWithArraySyntax()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testExposeTwoMethodsWithArraySyntax();
    }

    public function testMockingPrivateMethodWillThrowException()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMockingPrivateMethodWillThrowException();
    }

    public function testMethodsCanReturnSelf()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMethodsCanReturnSelf();
    }
}
