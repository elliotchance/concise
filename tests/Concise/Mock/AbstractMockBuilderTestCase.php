<?php

namespace Concise\Mock;

use Concise\TestCase;

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

    abstract public function getClassName();

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

    /**
     * @group #225
     */
    public function testMultipleWithsNotBeingFullfilled()
    {
        $mock = $this->niceMockBuilder()
                     ->expect('myMethod')->with('foo')
                                         ->with('bar')->never()
                     ->get();

        $mock->myMethod('foo');
    }

    /**
     * @group #225
     */
    public function testMultipleWithsNotBeingFullfilledInDifferentOrder()
    {
        $mock = $this->niceMockBuilder()
                     ->expect('myMethod')->with('bar')->never()
                                         ->with('foo')
                     ->get();

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
        $this->mockBuilder()
             ->stub('myMethod')->andReturnCallback(function () use (&$count) {
                ++$count;
            })
             ->get();
        $this->assert($count, equals, 0);
    }

    public function testAReturnCallbackWillBeProvidedACountThatStartsAt1()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturnCallback(function (InvocationInterface $i) {
                        return $i->getInvokeCount();
                    })
                     ->get();
        $this->assert($mock->myMethod(), equals, 1);
    }

    public function testAReturnCallbackWillBeProvidedACountThatIncrementsWithInvocations()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturnCallback(function (InvocationInterface $i) {
                        return $i->getInvokeCount();
                    })
                     ->get();
        $mock->myMethod();
        $this->assert($mock->myMethod(), equals, 2);
    }

    public function testAReturnCallbackWillBeProvidedWithOriginalArgs()
    {
        $mock = $this->mockBuilder()
                     ->stub('myMethod')->andReturnCallback(function (InvocationInterface $i) {
                        return $i->getArguments();
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

    // getProperty / setProperty

    public function testGetAProtectedProperty()
    {
        $mock = $this->niceMockBuilder()
                     ->get();
        $this->assert($this->getProperty($mock, 'hidden'), equals, 'foo');
    }

    public function testSetAProtectedProperty()
    {
        $mock = $this->niceMockBuilder()
                     ->get();
        $this->setProperty($mock, 'hidden', 'bar');
        $this->assert($this->getProperty($mock, 'hidden'), equals, 'bar');
    }

    /**
     * @group #182
     */
    public function testSetAPrivatePropertyOnAMockWillSetThePropertyOnTheNonMockedClass()
    {
        $mock = $this->niceMockBuilder()
            ->get();
        $this->setProperty($mock, 'secret', 'ok');
        $this->assert($this->getProperty($mock, 'secret'), equals, 'ok');
    }

    // MockInterface

    public function testMockImplementsMockInterface()
    {
        $mock = $this->mockBuilder()->get();
        $this->assert($mock, instance_of, '\Concise\Mock\MockInterface');
    }
}
