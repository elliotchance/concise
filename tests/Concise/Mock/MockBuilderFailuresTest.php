<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockBuilderFailuresTest extends TestCase
{
    protected static $failures = array();

    protected static $expectedFailures = array(
        'testFailedToFulfilExpectationWillThrowException' => 'Expected myMethod() to be called once, but it was called never.',
        'testMethodCalledWithWrongArgumentValues' => 'Expected myMethod("foo") to be called once, but it was called never.',
        'testMissingSecondWithExpectation' => 'Expected myMethod("foo") to be called once, but it was called never.',
        'testExpectationsRenderMultipleArguments' => 'Expected myMethod("foo", "bar") to be called once, but it was called never.',
        'testMissingAllExpectations' => 'Expected myMethod("foo") to be called once, but it was called never.',
        'testLessTimesThanExpected' => 'Expected myMethod("foo") to be called twice, but it was called once.',
        'testMoreTimesThanExpected' => 'Expected myMethod("foo") to be called twice, but it was called 3 times.',
        'testExpectionThatIsNeverCalledWillFail' => 'Expected myMethod("foo") to be called once, but it was called never.',
        'testExpectionMustBeCalledTheRequiredAmountOfTimes' => 'Expected myMethod("foo") to be called twice, but it was called once.',
        'testWithArgumentsMayContainPercentageThatWasntCalled' => 'Expected myMethod("%d") to be called once, but it was called never.',
        'testWithArgumentsWillNotMistakeAnArrayForACallback' => 'Expected myMethod(["DateTime","getLastErrors"]) to be called once, but it was called never.',
        'testWithArgumentsUsingDifferentCallback' => 'Expected myMethod(["DateTime","__set_state"]) to be called once, but it was called never.',
        'testAbstractMethodOnANiceMockThatHasNoActionWillThrowException' => 'myMethod() is abstract and has no associated action.',
        'testAnythingIsRenderedCorrectly' => 'Expected myMethod(<ANYTHING>, "foo") to be called once, but it was called never.',
    );

    public function testFailedToFulfilExpectationWillThrowException()
    {
        $this->mock('\Concise\Mock\Mock1')
             ->expect('myMethod')
             ->get();
    }

    public function testMethodCalledWithWrongArgumentValues()
    {
        $this->mock = $this->mock('\Concise\Mock\Mock1')
                           ->expect('myMethod')->with('foo')
                           ->get();
        $this->mock->myMethod('bar');
    }

    public function testMissingSecondWithExpectation()
    {
        $this->mock = $this->mock('\Concise\Mock\Mock1')
                           ->expect('myMethod')->with('foo')->with('bar')
                           ->get();
        $this->mock->myMethod('bar');
    }

    public function testExpectationsRenderMultipleArguments()
    {
        $this->mock = $this->mock('\Concise\Mock\Mock1')
                           ->expect('myMethod')->with('foo', 'bar')
                           ->get();
        $this->mock->myMethod('bar');
    }

    public function testMissingAllExpectations()
    {
        $this->mock('\Concise\Mock\Mock1')
             ->expect('myMethod')->with('foo')->with('bar')
             ->get();
    }

    public function testLessTimesThanExpected()
    {
        $this->mock = $this->mock('\Concise\Mock\Mock1')
                           ->expect('myMethod')->with('foo')->twice()
                                               ->with('bar')
                           ->get();
        $this->mock->myMethod('foo');
    }

    public function testExpectionThatIsNeverCalledWillFail()
    {
        $this->mock('\Concise\Mock\Mock1')
             ->expect('myMethod')->with('foo')->andReturn('bar')
             ->get();
    }

    public function testExpectionMustBeCalledTheRequiredAmountOfTimes()
    {
        $this->mock = $this->mock('\Concise\Mock\Mock1')
                           ->expect('myMethod')->with('foo')->twice()->andReturn('bar')
                           ->get();
        $this->mock->myMethod('foo');
    }

    public function testMoreTimesThanExpected()
    {
        $this->mock = $this->mock('\Concise\Mock\Mock1')
                           ->expect('myMethod')->with('foo')->twice()
                                               ->with('bar')
                           ->get();
        $this->mock->myMethod('foo');
        $this->mock->myMethod('foo');
        $this->mock->myMethod('foo');
    }

    public function testWithArgumentsMayContainPercentageThatWasntCalled()
    {
        $mock = $this->mock('\Concise\Mock\Mock1')
                     ->expects('myMethod')->with('%d')
                     ->get();
    }

    public function testWithArgumentsWillNotMistakeAnArrayForACallback()
    {
        $mock = $this->mock('\Concise\Mock\Mock1')
                     ->expects('myMethod')->with(array('DateTime', 'getLastErrors'))
                     ->get();
    }

    public function testWithArgumentsUsingDifferentCallback()
    {
        $mock = $this->mock('\Concise\Mock\Mock1')
                     ->expects('myMethod')->with(array('DateTime', '__set_state'))
                     ->get();
        $mock->myMethod(array('DateTime', 'getLastErrors'));
    }

    public function testAbstractMethodOnANiceMockThatHasNoActionWillThrowException()
    {
        $mock = $this->niceMock('\Concise\Mock\AbstractMock1')
                     ->get();
        $mock->myMethod();
    }

    public function testAnythingIsRenderedCorrectly()
    {
        $mock = $this->mock('\Concise\Mock\Mock1')
                     ->expects('myMethod')->with(self::ANYTHING, 'foo')
                     ->get();
    }

    protected function onNotSuccessfulTest(\Exception $e)
    {
        self::$failures[] = $this->getName();
        $this->assert(self::$expectedFailures[$this->getName()], equals, $e->getMessage());
    }

    public static function tearDownAfterClass()
    {
        $a = array_keys(self::$expectedFailures);
        $b = self::$failures;
        $testCase = new TestCase();
        $testCase->setUp();
        $testCase->assert(array_diff($a, $b), equals, array_diff($b, $a));
        $testCase->tearDown();
    }
}
