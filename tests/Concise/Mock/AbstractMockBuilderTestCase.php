<?php

namespace Concise\Mock;

use \Concise\TestCase;

abstract class AbstractMockBuilderTestCase extends TestCase
{
    protected function expectFailure($message, $exceptionClass = '\InvalidArgumentException')
    {
        $this->setExpectedException($exceptionClass, $message);
    }

    protected function notApplicable()
    {
        $this->assert(true);
    }

    protected function mockBuilder()
    {
        return $this->mock($this->getClassName(), array(1, 2));
    }

    protected function niceMockBuilder()
    {
        return $this->niceMock($this->getClassName(), array(1, 2));
    }

    public function testMockCanBeCreatedFromAnObjectThatExists()
    {
        $mock = $this->mockBuilder()
                     ->get();
        $this->assert($mock, instance_of, $this->getClassName());
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage myMethod() does not have an associated action - consider a niceMock()?
     */
    public function testCallingMethodThatHasNoAssociatedActionWillThrowAnException()
    {
        $mock = $this->mockBuilder()
                     ->get();
        $mock->myMethod();
    }

    public function testNiceMockCanBeCreatedFromAnObjectThatExists()
    {
        $mock = $this->niceMockBuilder()
                     ->get();
        $this->assert($mock, instance_of, $this->getClassName());
    }

    public function testCallingMethodThatHasNoAssociatedActionOnANiceMockWillUseOriginal()
    {
        $mock = $this->niceMockBuilder()
                     ->get();
        $this->assert($mock->myMethod(), equals, 'abc');
    }

    abstract public function getClassName();

    // Constructor

    public function testMocksCanHaveTheirConstructorDisabled()
    {
        $mock = $this->mock($this->getClassName())
                     ->disableConstructor()
                     ->get();
        $this->assert($mock->constructorRun, is_false);
    }

    public function testMockReceivesConstructorArguments()
    {
        $mock = $this->mockBuilder()
                     ->get();
        $this->assert($mock->constructorRun, equals, 2);
    }

    public function testNiceMockReceivesConstructorArguments()
    {
        $mock = $this->niceMockBuilder()
                     ->get();
        $this->assert($mock->constructorRun, equals, 2);
    }

    // Do

    public function testACallbackCanBeSet()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andDo(function () {})
                     ->get();
        $this->assert($mock->myMethod(), equals, null);
    }

    public function testTheCallbackWillBeExecuted()
    {
        $a = 123;
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andDo(function () use (&$a) {
                         $a = 456;
                     })
                     ->get();
        $mock->myMethod();
        $this->assert($a, equals, 456);
    }

    public function testTheCallbackWillNotBeExecutedIfNotCalled()
    {
        $a = 123;
        $this->mockBuilder()
             ->stub('myMethod')->andDo(function () use (&$a) {
                 $a = 456;
             })
             ->get();
        $this->assert($a, equals, 123);
    }

    // Expect

    public function testCanCreateAnExpectation()
    {
        $mock = $this->mockBuilder()
                     ->expect('myMethod')->once()->andReturn(null)
                     ->get();
        $mock->myMethod();
    }

    public function testCanCreateAnExpectationOfTwice()
    {
        $mock = $this->mockBuilder()
                     ->expect('myMethod')->twice()->andReturn(null)
                     ->get();
        $mock->myMethod();
        $mock->myMethod();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage You cannot assign an action to 'myMethod()' when it is never expected.
     */
    public function testAddingAnActionOntoAMethodThatIsNeverExpectedThrowsException()
    {
        $this->mockBuilder()
             ->expect('myMethod')->never()->andReturn(null)
             ->get();
    }

    public function testWeDoNotNeedToSpecifyAnActionForAnExpectationWeNeverWantToHappen()
    {
        $this->mockBuilder()
             ->expect('myMethod')->never()
             ->get();
    }

    public function testCanCreateAnExpectationOfASpecificAmountOfTimes()
    {
        $mock = $this->mockBuilder()
                     ->expect('myMethod')->exactly(3)->andReturn(null)
                     ->get();
        $mock->myMethod();
        $mock->myMethod();
        $mock->myMethod();
    }

    public function testExactlyZeroIsTheSameAsNever()
    {
        $this->mockBuilder()
             ->expect('myMethod')->exactly(0)
             ->get();
    }

    public function testDefaultExpectationIsOnce()
    {
        $mock = $this->mockBuilder()
                     ->expect('myMethod')->andReturn(null)
                     ->get();
        $mock->myMethod();
    }

    public function testCanCreateAnExpectationWithArgumentValues()
    {
        $mock = $this->mockBuilder()
                     ->expect('myMethod')->with('foo')->andReturn('bar')
                     ->get();
        $this->assert($mock->myMethod('foo'), equals, 'bar');
    }

    public function testCanUseExpectsInsteadOfExpect()
    {
        $mock = $this->mockBuilder()
                     ->expects('myMethod')
                     ->get();
        $mock->myMethod();
    }

    public function testExpectWithMultipleArguments()
    {
        $mock = $this->mockBuilder()
            ->expect('myMethod', 'mySecondMethod')
            ->get();
        $mock->myMethod();
        $mock->mySecondMethod();
    }

    public function testExpectsWithMultipleArguments()
    {
        $mock = $this->mockBuilder()
            ->expects('myMethod', 'mySecondMethod')
            ->get();
        $mock->myMethod();
        $mock->mySecondMethod();
    }

    // Expose

    public function testExposeASingleMethod()
    {
        $mock = $this->niceMockBuilder()
                     ->expose('mySecretMethod')
                     ->get();
        $this->assert($mock->myMethod(), equals, 'abc');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage does not exist.
     */
    public function testAnExceptionIsThrownIfTheMethodDoesNotExist()
    {
        $this->niceMockBuilder()
             ->expose('baz')
             ->get();
    }

    public function testExposeTwoMethodsWithSeparateParameters()
    {
        $mock = $this->niceMockBuilder()
                     ->expose('myMethod', 'mySecondMethod')
                     ->get();
        $this->assert($mock->mySecondMethod(), equals, 'bar');
    }

    public function testExposeTwoMethodsByCallingExposeTwice()
    {
        $mock = $this->niceMockBuilder()
                     ->expose('myMethod')->expose('mySecondMethod')
                     ->get();
        $this->assert($mock->myMethod(), equals, 'abc');
    }

    public function testExposeTwoMethodsWithArraySyntax()
    {
        $mock = $this->niceMockBuilder()
                     ->expose(array('myMethod', 'mySecondMethod'))
                     ->get();
        $this->assert($mock->mySecondMethod(), equals, 'bar');
    }

    // Private

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage cannot be mocked because it it private.
     */
    public function testMockingPrivateMethodWillThrowException()
    {
        $this->mockBuilder()
             ->stub(array('myPrivateMethod' => 'bar'))
             ->get();
    }

    // ReturnSelf

    public function testMethodsCanReturnSelf()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturnSelf()
                     ->get();
        $this->assert($mock->myMethod(), is_the_same_as, $mock);
    }

    // Return

    public function testAndReturnWithASingleArgument()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturn('foo')
                     ->get();
        $this->assert($mock->myMethod(), equals, 'foo');
    }

    public function testAndReturnCanTakeMultipleArguments()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturn('foo', 'bar')
                     ->get();
        $this->assert($mock->myMethod(), equals, 'foo');
    }

    public function testAndReturnWithMultipleArgumentsCanBeCalledWithDifferentResults()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturn('foo', 'bar')
                     ->get();
        $mock->myMethod();
        $this->assert($mock->myMethod(), equals, 'bar');
    }

    public function testAndReturnWithASingleArgumentWillAlwaysReturnThatValue()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturn('foo')
                     ->get();
        $mock->myMethod();
        $mock->myMethod();
        $this->assert($mock->myMethod(), equals, 'foo');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Only 2 return values have been provided.
     */
    public function testAndReturnWithMultipleArgumentsCanNotBeCalledMoreTimesThatReturnValues()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturn('foo', 'bar')
                     ->get();
        $mock->myMethod();
        $mock->myMethod();
        $mock->myMethod();
    }

    // Static

    public function testMocksCanMockStaticMethods()
    {
        $mock = $this->mockBuilder()
                     ->stub(array('myStaticMethod' => 'foo'))
                     ->get();
        $this->assert($mock->myStaticMethod(), equals, 'foo');
    }

    // Stub

    public function testCanStubMethodWithAssociativeArray()
    {
        $mock = $this->mockBuilder()
                     ->stub(array('myMethod' => 123))
                     ->get();
        $this->assert($mock->myMethod(), equals, 123);
    }

    public function testStubbingWithAnArrayCanCreateMultipleStubs()
    {
        $mock = $this->mockBuilder()
                     ->stub(array('myMethod' => 123, 'mySecondMethod' => 'bar'))
                     ->get();
        $this->assert($mock->mySecondMethod(), equals, 'bar');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage stub() called with array must have at least 1 element.
     */
    public function testStubbingWithAnArrayMustHaveMoreThanZeroElements()
    {
        $this->mockBuilder()
             ->stub(array())
             ->get();
    }

    public function testCallingMethodOnNiceMockWithStub()
    {
        $mock = $this->niceMockBuilder()
                     ->stub(array('myMethod' => 123))
                     ->get();
        $this->assert($mock->myMethod(), equals, 123);
    }

    public function testStubsCanBeCreatedByChainingAnAction()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturn(123)
                     ->get();
        $this->assert($mock->myMethod(), equals, 123);
    }

    public function testStubWithNoActionWillReturnNull()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')
                     ->get();
        $this->assert($mock->myMethod(), is_null);
    }

    public function testStubCanReturnNull()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturn(null)
                     ->get();
        $this->assert($mock->myMethod(), is_null);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage whatever
     */
    public function testStubCanThrowException()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andThrow(new \Exception('whatever'))
                     ->get();
        $mock->myMethod();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage myMethod() has more than one action attached.
     */
    public function testMethodsCanOnlyHaveOneActionAppliedToThem()
    {
        $this->mockBuilder()
             ->stub('myMethod')->andReturn(123)->andReturn(456)
             ->get();
    }

    protected function getLastElement(array $a)
    {
        return $a[count($a) - 1];
    }

    public function testMockSetsActualCallsToZeroWhenRuleIsCreated()
    {
        $this->mockBuilder()
             ->stub(array('myMethod' => 123))
             ->get();

        $mock = $this->getLastElement($this->getMockManager()->getMocks());
        $this->assert(count($mock['instance']->getCallsForMethod('myMethod')), exactly_equals, 0);
    }

    public function testMockSetsCalledTimesToOneWhenMethodIsCalled()
    {
        $mock = $this->mockBuilder()
                     ->stub(array('myMethod' => 123))
                     ->get();

        $mock->myMethod();

        $mock = $this->getLastElement($this->getMockManager()->getMocks());
        $this->assert(count($mock['instance']->getCallsForMethod('myMethod')), exactly_equals, 1);
    }

    public function testMockSetsCalledTimesIncrementsWithMultipleCalls()
    {
        $mock = $this->mockBuilder()
                     ->stub(array('myMethod' => 123))
                     ->get();

        $mock->myMethod();
        $mock->myMethod();

        $mock = $this->getLastElement($this->getMockManager()->getMocks());
        $this->assert(count($mock['instance']->getCallsForMethod('myMethod')), exactly_equals, 2);
    }
    
    public function testStubbingMultipleMethodsWithMultipleArguments()
    {
        $mock = $this->niceMockBuilder()
            ->stub('myMethod', 'mySecondMethod')
            ->get();
        $this->assert($mock->mySecondMethod(), is_null);
    }

    public function testFirstMethodOfMultipleStubsReceivesAction()
    {
        $mock = $this->niceMockBuilder()
            ->stub('myMethod', 'mySecondMethod')->andReturn('foo')
            ->get();
        $this->assert($mock->myMethod(), equals, 'foo');
    }

    public function testSecondMethodOfMultipleStubsReceivesAction()
    {
        $mock = $this->niceMockBuilder()
            ->stub('myMethod', 'mySecondMethod')->andReturn('foo')
            ->get();
        $this->assert($mock->mySecondMethod(), equals, 'foo');
    }

    // With

    public function testMultipleWithIsAllowedForASingleMethod()
    {
        $mock = $this->mockBuilder()
                     ->stub('myWithMethod')->with('a')->andReturn('foo')
                                           ->with('b')->andReturn('bar')
                     ->get();
        $this->assert($mock, instance_of, $this->getClassName());
    }

    public function testMultipleWithCanChangeTheActionOfTheMethod()
    {
        $mock = $this->mockBuilder()
                     ->stub('myWithMethod')->with('a')->andReturn('foo')
                                           ->with('b')->andReturn('bar')
                     ->get();
        $this->assert($mock->myWithMethod('b'), equals, 'bar');
    }

    public function testTheSecondWithActionWillNotOverrideTheFirstOne()
    {
        $mock = $this->mockBuilder()
                     ->stub('myWithMethod')->with('a')->andReturn('foo')
                                           ->with('b')->andReturn('bar')
                     ->get();
        $this->assert($mock->myWithMethod('a'), equals, 'foo');
    }

    public function testSingleWithWithMultipleTimes()
    {
        $mock = $this->mockBuilder()
                     ->stub('myWithMethod')->with('a')->twice()->andReturn('foo')
                     ->get();
        $mock->myWithMethod('a');
        $this->assert($mock->myWithMethod('a'), equals, 'foo');
    }

    public function testStringsInExpectedArgumentsMustBeEscapedCorrectly()
    {
        $mock = $this->mockBuilder()
                     ->stub('myWithMethod')->with('"foo"')
                     ->get();
        $this->assert($mock->myWithMethod('"foo"'), is_null);
    }

    public function testStringsWithDollarCharacterMustBeEscaped()
    {
        $mock = $this->mockBuilder()
                     ->stub('myWithMethod')->with('a$b')
                     ->get();
        $this->assert($mock->myWithMethod('a$b'), is_null);
    }

    public function testWithOnMultipleMethods()
    {
        $mock = $this->mockBuilder()
            ->stub('myWithMethod', 'myMethod')->with('foo')->andReturn('foobar')
            ->get();
        $this->assert($mock->myMethod('foo'), equals, 'foobar');
    }

    public function testMultipleExpectsUsingTheSameWith()
    {
        $mock = $this->mockBuilder()
            ->expect('myWithMethod')->with('foo')
            ->expect('myMethod')->with('foo')
            ->get();
        $mock->myWithMethod('foo');
        $mock->myMethod('foo');
    }

    public function testMultipleExpectsUsingWith()
    {
        $mock = $this->mockBuilder()
            ->expect('myWithMethod', 'myMethod')->with('foo')
            ->get();
        $mock->myWithMethod('foo');
        $mock->myMethod('foo');
    }

    // Abstract

    public function testMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')
                     ->get();
        $this->assert($mock->myMethod(), is_null);
    }

    public function testNiceMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate()
    {
        $mock = $this->niceMockBuilder()
                     ->stub('myMethod')
                     ->get();
        $this->assert($mock->myMethod(), is_null);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage myAbstractMethod() does not have an associated action - consider a niceMock()?
     */
    public function testCallingAnAbstractMethodWithNoRuleThrowsException()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')
                     ->get();
        $mock->myAbstractMethod();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage myAbstractMethod() does not have an associated action - consider a niceMock()?
     */
    public function testCallingAnAbstractMethodOnANiceMockWithNoRuleThrowsException()
    {
        $mock = $this->niceMockBuilder()
                     ->stub('myMethod')
                     ->get();
        $mock->myAbstractMethod();
    }

    public function testAbstractMethodsCanHaveRulesAttached()
    {
        $mock = $this->mockBuilder()
                     ->stub('myAbstractMethod')
                     ->get();
        $this->assert($mock->myAbstractMethod(), is_null);
    }

    // Final

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage is final so it cannot be mocked
     */
    public function testFinalMethodsCanNotBeMocked()
    {
        $this->mockBuilder()
             ->stub('myFinalMethod')
             ->get();
    }

    // Custom Class Name

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid class name 'Concise\Mock\123'.
     */
    public function testWillThrowExceptionIfTheCustomNameIsNotValid()
    {
        $mock = $this->mockBuilder()
                     ->setCustomClassName('123')
                     ->get();
    }

    public function testCanSetCustomClassName()
    {
        $rand = "Concise\\Mock\\Temp" . md5(rand());
        $mock = $this->mockBuilder()
                     ->setCustomClassName($rand)
                     ->get();
        $this->assert(get_class($mock), equals, $rand);
    }

    // ReturnCallback

    public function testAReturnCallbackCanBeSet()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturnCallback(function () {})
                     ->get();
        $this->assert($mock->myMethod(), is_null);
    }

    public function testAReturnCallbackWillBeEvaluatedForItsReturnValue()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturnCallback(function () {
                        return 'foo';
                    })
                     ->get();
        $this->assert($mock->myMethod(), equals, 'foo');
    }

    public function testAReturnCallbackMustNotBeExecutedIfTheMethodWasNeverInvoked()
    {
        $count = 0;
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturnCallback(function () use (&$count) {
                        ++$count;
                    })
                     ->get();
        $this->assert($count, equals, 0);
    }

    public function testAReturnCallbackWillBeProvidedACountThatStartsAt1()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturnCallback(function ($count) {
                        return $count;
                    })
                     ->get();
        $this->assert($mock->myMethod(), equals, 1);
    }

    public function testAReturnCallbackWillBeProvidedACountThatIncrementsWithInvocations()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturnCallback(function ($count) {
                        return $count;
                    })
                     ->get();
        $mock->myMethod();
        $this->assert($mock->myMethod(), equals, 2);
    }

    public function testAReturnCallbackWillBeProvidedWithOriginalArgs()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturnCallback(function ($count, array $args) {
                        return $args;
                    })
                     ->get();
        $this->assert($mock->myMethod('hello'), equals, array('hello'));
    }

    // ReturnProperty

    public function testAReturnPropertyCanBeSet()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturnProperty('hidden')
                     ->get();
        $this->assert($mock->myMethod(), equals, 'foo');
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Property 'doesnt_exist' does not exist for
     */
    public function testAnExceptionIsThrownIfPropertyDoesNotExistAtRuntime()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturnProperty('doesnt_exist')
                     ->get();
        $mock->myMethod();
    }

    // ANYTHING

    public function testWithParameterCanAcceptAnything()
    {
        $mock = $this->mockBuilder()
                     ->expect('myMethod')->with(self::ANYTHING)->andReturn('foo')
                     ->get();
        $this->assert($mock->myMethod(null), equals, 'foo');
    }

    public function testWithParameterCanAcceptAnythingElse()
    {
        $mock = $this->mockBuilder()
                     ->expect('myMethod')->with(self::ANYTHING)->andReturn('foo')
                     ->get();
        $this->assert($mock->myMethod(123), equals, 'foo');
    }

    // getProperty

    public function testGetAProptectedProperty()
    {
        $mock = $this->niceMockBuilder()
                     ->get();
        $this->assert($this->getProperty($mock, 'hidden'), equals, 'foo');
    }

    public function testSetAProptectedProperty()
    {
        $mock = $this->niceMockBuilder()
                     ->get();
        $this->setProperty($mock, 'hidden', 'bar');
        $this->assert($this->getProperty($mock, 'hidden'), equals, 'bar');
    }

    // MockInterface

    public function testMockImplementsMockInterface()
    {
        $mock = $this->mockBuilder()->get();
        $this->assert($mock, instance_of, '\Concise\Mock\MockInterface');
    }
}
