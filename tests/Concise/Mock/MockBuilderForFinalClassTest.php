<?php

namespace Concise\Mock;

final class MockFinalClass
{
    public $constructorRun = false;

    protected $hidden = 'foo';

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

    public static function myStaticMethod()
    {
        return 'foo';
    }

    public function myWithMethod($a)
    {
    }

    final public function myFinalMethod()
    {
    }
}

class MockFinalClass2
{
    final public function myMethod()
    {
    }
}

/**
 * @group mocking
 */
class MockBuilderForFinalClassTest extends AbstractMockBuilderTestCase
{
    public function getClassName()
    {
        return '\Concise\Mock\MockFinalClass';
    }

    public function testFinalMethodsWillNotBeOverriddenInChildClasses()
    {
        $mock = $this->mock('\Concise\Mock\MockFinalClass2')
                     ->get();
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

    public function testAndReturnWithASingleArgument()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testAndReturnWithASingleArgument();
    }

    public function testAndReturnWithMultipleArgumentsCanNotBeCalledMoreTimesThatReturnValues()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testAndReturnWithMultipleArgumentsCanNotBeCalledMoreTimesThatReturnValues();
    }

    public function testAndReturnWithASingleArgumentWillAlwaysReturnThatValue()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testAndReturnWithASingleArgumentWillAlwaysReturnThatValue();
    }

    public function testAndReturnWithMultipleArgumentsCanBeCalledWithDifferentResults()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testAndReturnWithMultipleArgumentsCanBeCalledWithDifferentResults();
    }

    public function testAndReturnCanTakeMultipleArguments()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testAndReturnCanTakeMultipleArguments();
    }

    public function testMocksCanMockStaticMethods()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMocksCanMockStaticMethods();
    }

    public function testCanStubMethodWithAssociativeArray()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testCanStubMethodWithAssociativeArray();
    }

    public function testStubbingWithAnArrayCanCreateMultipleStubs()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testStubbingWithAnArrayCanCreateMultipleStubs();
    }

    public function testCallingMethodOnNiceMockWithStub()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testCallingMethodOnNiceMockWithStub();
    }

    public function testStubsCanBeCreatedByChainingAnAction()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testStubsCanBeCreatedByChainingAnAction();
    }

    public function testStubWithNoActionWillReturnNull()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testStubWithNoActionWillReturnNull();
    }

    public function testStubCanReturnNull()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testStubCanReturnNull();
    }

    public function testStubCanThrowException()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testStubCanThrowException();
    }

    public function testMockSetsActualCallsToZeroWhenRuleIsCreated()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMockSetsActualCallsToZeroWhenRuleIsCreated();
    }

    public function testMockSetsCalledTimesToOneWhenMethodIsCalled()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMockSetsCalledTimesToOneWhenMethodIsCalled();
    }

    public function testMockSetsCalledTimesIncrementsWithMultipleCalls()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMockSetsCalledTimesIncrementsWithMultipleCalls();
    }

    public function testMultipleWithIsAllowedForASingleMethod()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMultipleWithIsAllowedForASingleMethod();
    }

    public function testMultipleWithCanChangeTheActionOfTheMethod()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMultipleWithCanChangeTheActionOfTheMethod();
    }

    public function testTheSecondWithActionWillNotOverrideTheFirstOne()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testTheSecondWithActionWillNotOverrideTheFirstOne();
    }

    public function testSingleWithWithMultipleTimes()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testSingleWithWithMultipleTimes();
    }

    public function testStringsInExpectedArgumentsMustBeEscapedCorrectly()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testStringsInExpectedArgumentsMustBeEscapedCorrectly();
    }

    public function testStringsWithDollarCharacterMustBeEscaped()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testStringsWithDollarCharacterMustBeEscaped();
    }

    public function testMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate();
    }

    public function testNiceMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testNiceMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate();
    }

    public function testCallingAnAbstractMethodWithNoRuleThrowsException()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testCallingAnAbstractMethodWithNoRuleThrowsException();
    }

    public function testCallingAnAbstractMethodOnANiceMockWithNoRuleThrowsException()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testCallingAnAbstractMethodOnANiceMockWithNoRuleThrowsException();
    }

    public function testAbstractMethodsCanHaveRulesAttached()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testAbstractMethodsCanHaveRulesAttached();
    }

    public function testCanSetCustomClassName()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testCanSetCustomClassName();
    }

    public function testAReturnCallbackCanBeSet()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testAReturnCallbackCanBeSet();
    }

    public function testAReturnCallbackWillBeEvaluatedForItsReturnValue()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testAReturnCallbackWillBeEvaluatedForItsReturnValue();
    }

    public function testAReturnCallbackMustNotBeExecutedIfTheMethodWasNeverInvoked()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testAReturnCallbackMustNotBeExecutedIfTheMethodWasNeverInvoked();
    }

    public function testAReturnCallbackWillBeProvidedACountThatStartsAt1()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testAReturnCallbackWillBeProvidedACountThatStartsAt1();
    }

    public function testAReturnCallbackWillBeProvidedACountThatIncrementsWithInvocations()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testAReturnCallbackWillBeProvidedACountThatIncrementsWithInvocations();
    }

    public function testAReturnCallbackWillBeProvidedWithOriginalArgs()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testAReturnCallbackWillBeProvidedWithOriginalArgs();
    }

    public function testAReturnPropertyCanBeSet()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testAReturnPropertyCanBeSet();
    }

    public function testAnExceptionIsThrownIfPropertyDoesNotExistAtRuntime()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testAnExceptionIsThrownIfPropertyDoesNotExistAtRuntime();
    }

    public function testWithParameterCanAcceptAnything()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testWithParameterCanAcceptAnything();
    }

    public function testWithParameterCanAcceptAnythingElse()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testWithParameterCanAcceptAnythingElse();
    }

    public function testGetAProptectedProperty()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testGetAProptectedProperty();
    }

    public function testSetAProptectedProperty()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testSetAProptectedProperty();
    }

    public function testStubbingMultipleMethodsWithMultipleArguments()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testStubbingMultipleMethodsWithMultipleArguments();
    }

    public function testFirstMethodOfMultipleStubsReceivesAction()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testFirstMethodOfMultipleStubsReceivesAction();
    }

    public function testSecondMethodOfMultipleStubsReceivesAction()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testSecondMethodOfMultipleStubsReceivesAction();
    }

    public function testMockImplementsMockInterface()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMockImplementsMockInterface();
    }

    public function testExpectWithMultipleArguments()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testExpectWithMultipleArguments();
    }

    public function testExpectsWithMultipleArguments()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testExpectsWithMultipleArguments();
    }

    public function testWithOnMultipleMethods()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testWithOnMultipleMethods();
    }

    public function testMultipleExpectsUsingTheSameWith()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMultipleExpectsUsingTheSameWith();
    }

    public function testMultipleExpectsUsingWith()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMultipleExpectsUsingWith();
    }

    public function testMultipleExpectsThatAreNeverExpected()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMultipleExpectsThatAreNeverExpected();
    }

    public function testMultipleWithsNotBeingFullfilled()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMultipleWithsNotBeingFullfilled();
    }

    public function testMultipleWithsNotBeingFullfilledInDifferentOrder()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMultipleWithsNotBeingFullfilledInDifferentOrder();
    }

    /**
     * @group #182
     */
    public function testAndDoWillBeProvidedACountThatStartsAt1()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testAndDoWillBeProvidedACountThatStartsAt1();
    }
}
