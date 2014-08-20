<?php

namespace Concise\Mock;

use \Concise\TestCase;

abstract class AbstractMockBuilderTestCase extends TestCase
{
    protected function expectFailure($message)
    {
        $this->setExpectedException('\InvalidArgumentException', $message);
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
                     ->done();
        $this->assert($mock, instance_of, $this->getClassName());
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage myMethod() does not have an associated action - consider a niceMock()?
     */
    public function testCallingMethodThatHasNoAssociatedActionWillThrowAnException()
    {
        $mock = $this->mockBuilder()
                     ->done();
        $mock->myMethod();
    }

    public function testNiceMockCanBeCreatedFromAnObjectThatExists()
    {
        $mock = $this->niceMockBuilder()
                     ->done();
        $this->assert($mock, instance_of, $this->getClassName());
    }

    public function testCallingMethodThatHasNoAssociatedActionOnANiceMockWillUseOriginal()
    {
        $mock = $this->niceMockBuilder()
                     ->done();
        $this->assert($mock->myMethod(), equals, 'abc');
    }

    abstract public function getClassName();

    // Constructor

    public function testMocksCanHaveTheirConstructorDisabled()
    {
        $mock = $this->mock($this->getClassName())
                     ->disableConstructor()
                     ->done();
        $this->assert($mock->constructorRun, is_false);
    }

    public function testMockReceivesConstructorArguments()
    {
        $mock = $this->mockBuilder()
                     ->done();
        $this->assert($mock->constructorRun, equals, 2);
    }

    public function testNiceMockReceivesConstructorArguments()
    {
        $mock = $this->niceMockBuilder()
                     ->done();
        $this->assert($mock->constructorRun, equals, 2);
    }

    // Do

    public function testACallbackCanBeSet()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andDo(function () {})
                     ->done();
        $this->assert($mock->myMethod(), equals, null);
    }

    public function testTheCallbackWillBeExecuted()
    {
        $a = 123;
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andDo(function () use (&$a) {
                         $a = 456;
                     })
                     ->done();
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
             ->done();
        $this->assert($a, equals, 123);
    }

    // Expect

    public function testCanCreateAnExpectation()
    {
        $mock = $this->mockBuilder()
                     ->expect('myMethod')->once()->andReturn(null)
                     ->done();
        $mock->myMethod();
    }

    public function testCanCreateAnExpectationOfTwice()
    {
        $mock = $this->mockBuilder()
                     ->expect('myMethod')->twice()->andReturn(null)
                     ->done();
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
             ->done();
    }

    public function testWeDoNotNeedToSpecifyAnActionForAnExpectationWeNeverWantToHappen()
    {
        $this->mockBuilder()
             ->expect('myMethod')->never()
             ->done();
    }

    public function testCanCreateAnExpectationOfASpecificAmountOfTimes()
    {
        $mock = $this->mockBuilder()
                     ->expect('myMethod')->exactly(3)->andReturn(null)
                     ->done();
        $mock->myMethod();
        $mock->myMethod();
        $mock->myMethod();
    }

    public function testExactlyZeroIsTheSameAsNever()
    {
        $this->mockBuilder()
             ->expect('myMethod')->exactly(0)
             ->done();
    }

    public function testDefaultExpectationIsOnce()
    {
        $mock = $this->mockBuilder()
                     ->expect('myMethod')->andReturn(null)
                     ->done();
        $mock->myMethod();
    }

    public function testCanCreateAnExpectationWithArgumentValues()
    {
        $mock = $this->mockBuilder()
                     ->expect('myMethod')->with('foo')->andReturn('bar')
                     ->done();
        $this->assert($mock->myMethod('foo'), equals, 'bar');
    }

    public function testCanUseExpectsInsteadOfExpect()
    {
        $mock = $this->mockBuilder()
                     ->expects('myMethod')
                     ->done();
        $mock->myMethod();
    }

    // Expose

    public function testExposeASingleMethod()
    {
        $mock = $this->niceMockBuilder()
                     ->expose('mySecretMethod')
                     ->done();
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
             ->done();
    }

    public function testExposeTwoMethodsWithSeparateParameters()
    {
        $mock = $this->niceMockBuilder()
                     ->expose('myMethod', 'mySecondMethod')
                     ->done();
        $this->assert($mock->mySecondMethod(), equals, 'bar');
    }

    public function testExposeTwoMethodsByCallingExposeTwice()
    {
        $mock = $this->niceMockBuilder()
                     ->expose('myMethod')->expose('mySecondMethod')
                     ->done();
        $this->assert($mock->myMethod(), equals, 'abc');
    }

    public function testExposeTwoMethodsWithArraySyntax()
    {
        $mock = $this->niceMockBuilder()
                     ->expose(array('myMethod', 'mySecondMethod'))
                     ->done();
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
             ->done();
    }

    // ReturnSelf

    public function testMethodsCanReturnSelf()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturnSelf()
                     ->done();
        $this->assert($mock->myMethod(), is_the_same_as, $mock);
    }

    // Return

    public function testAndReturnWithASingleArgument()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturn('foo')
                     ->done();
        $this->assert($mock->myMethod(), equals, 'foo');
    }

    public function testAndReturnCanTakeMultipleArguments()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturn('foo', 'bar')
                     ->done();
        $this->assert($mock->myMethod(), equals, 'foo');
    }

    public function testAndReturnWithMultipleArgumentsCanBeCalledWithDifferentResults()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturn('foo', 'bar')
                     ->done();
        $mock->myMethod();
        $this->assert($mock->myMethod(), equals, 'bar');
    }

    public function testAndReturnWithASingleArgumentWillAlwaysReturnThatValue()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturn('foo')
                     ->done();
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
                     ->done();
        $mock->myMethod();
        $mock->myMethod();
        $mock->myMethod();
    }

    // Static

    public function testMocksCanMockStaticMethods()
    {
        $mock = $this->mockBuilder()
                     ->stub(array('myStaticMethod' => 'foo'))
                     ->done();
        $this->assert($mock->myStaticMethod(), equals, 'foo');
    }

    // Stub

    public function testCanStubMethodWithAssociativeArray()
    {
        $mock = $this->mockBuilder()
                     ->stub(array('myMethod' => 123))
                     ->done();
        $this->assert($mock->myMethod(), equals, 123);
    }

    public function testStubbingWithAnArrayCanCreateMultipleStubs()
    {
        $mock = $this->mockBuilder()
                     ->stub(array('myMethod' => 123, 'mySecondMethod' => 'bar'))
                     ->done();
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
             ->done();
    }

    public function testCallingMethodOnNiceMockWithStub()
    {
        $mock = $this->niceMockBuilder()
                     ->stub(array('myMethod' => 123))
                     ->done();
        $this->assert($mock->myMethod(), equals, 123);
    }

    public function testStubsCanBeCreatedByChainingAnAction()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturn(123)
                     ->done();
        $this->assert($mock->myMethod(), equals, 123);
    }

    public function testStubWithNoActionWillReturnNull()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')
                     ->done();
        $this->assert($mock->myMethod(), is_null);
    }

    public function testStubCanReturnNull()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturn(null)
                     ->done();
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
                     ->done();
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
             ->done();
    }

    public function testMockSetsActualCallsToZeroWhenRuleIsCreated()
    {
        $this->mockBuilder()
             ->stub(array('myMethod' => 123))
             ->done();

        $mock = end($this->_mocks);
        $this->assert(count($mock['instance']->getCallsForMethod('myMethod')), exactly_equals, 0);
    }

    public function testMockSetsCalledTimesToOneWhenMethodIsCalled()
    {
        $mock = $this->mockBuilder()
                     ->stub(array('myMethod' => 123))
                     ->done();

        $mock->myMethod();

        $mock = end($this->_mocks);
        $this->assert(count($mock['instance']->getCallsForMethod('myMethod')), exactly_equals, 1);
    }

    public function testMockSetsCalledTimesIncrementsWithMultipleCalls()
    {
        $mock = $this->mockBuilder()
                     ->stub(array('myMethod' => 123))
                     ->done();

        $mock->myMethod();
        $mock->myMethod();

        $mock = end($this->_mocks);
        $this->assert(count($mock['instance']->getCallsForMethod('myMethod')), exactly_equals, 2);
    }

    // With

    public function testMultipleWithIsAllowedForASingleMethod()
    {
        $mock = $this->mockBuilder()
                     ->stub('myWithMethod')->with('a')->andReturn('foo')
                                           ->with('b')->andReturn('bar')
                     ->done();
        $this->assert($mock, instance_of, $this->getClassName());
    }

    public function testMultipleWithCanChangeTheActionOfTheMethod()
    {
        $mock = $this->mockBuilder()
                     ->stub('myWithMethod')->with('a')->andReturn('foo')
                                           ->with('b')->andReturn('bar')
                     ->done();
        $this->assert($mock->myWithMethod('b'), equals, 'bar');
    }

    public function testTheSecondWithActionWillNotOverrideTheFirstOne()
    {
        $mock = $this->mockBuilder()
                     ->stub('myWithMethod')->with('a')->andReturn('foo')
                                           ->with('b')->andReturn('bar')
                     ->done();
        $this->assert($mock->myWithMethod('a'), equals, 'foo');
    }

    public function testSingleWithWithMultipleTimes()
    {
        $mock = $this->mockBuilder()
                     ->stub('myWithMethod')->with('a')->twice()->andReturn('foo')
                     ->done();
        $mock->myWithMethod('a');
        $this->assert($mock->myWithMethod('a'), equals, 'foo');
    }

    public function testStringsInExpectedArgumentsMustBeEscapedCorrectly()
    {
        $mock = $this->mockBuilder()
                     ->stub('myWithMethod')->with('"foo"')
                     ->done();
        $this->assert($mock->myWithMethod('"foo"'), is_null);
    }

    public function testStringsWithDollarCharacterMustBeEscaped()
    {
        $mock = $this->mockBuilder()
                     ->stub('myWithMethod')->with('a$b')
                     ->done();
        $this->assert($mock->myWithMethod('a$b'), is_null);
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
             ->done();
    }
}
