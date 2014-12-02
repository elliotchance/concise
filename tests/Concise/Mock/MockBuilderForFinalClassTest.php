<?php

namespace Concise\Mock;

final class MockFinalClass
{
    public $constructorRun = false;

    protected $hidden = 'foo';

    private $secret = 'bar';

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

    public function testGetAProtectedProperty()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testGetAProtectedProperty();
    }

    public function testSetAProtectedProperty()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testSetAProtectedProperty();
    }

    public function testMockImplementsMockInterface()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMockImplementsMockInterface();
    }

    public function testSetAPrivatePropertyOnAMockWillSetThePropertyOnTheNonMockedClass()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testSetAPrivatePropertyOnAMockWillSetThePropertyOnTheNonMockedClass();
    }
}
