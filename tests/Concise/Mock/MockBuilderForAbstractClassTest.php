<?php

namespace Concise\Mock;

abstract class MockAbstractClass
{
    public $constructorRun = false;

    protected $hidden = 'foo';

    public function __construct($a, $b)
    {
        $this->constructorRun = $b;
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

    abstract public function myAbstractMethod();

    final public function myFinalMethod()
    {
    }
}

class MockBuilderForAbstractClassTest extends AbstractMockBuilderTestCase
{
    public function getClassName()
    {
        return '\Concise\Mock\MockAbstractClass';
    }

    public function testCallingAnAbstractMethodWithNoRuleThrowsException()
    {
        $this->expectFailure('myAbstractMethod() is abstract and has no associated action.', '\Exception');
        parent::testCallingAnAbstractMethodWithNoRuleThrowsException();
    }

    public function testCallingAnAbstractMethodOnANiceMockWithNoRuleThrowsException()
    {
        $this->expectFailure('myAbstractMethod() is abstract and has no associated action.', '\Exception');
        parent::testCallingAnAbstractMethodOnANiceMockWithNoRuleThrowsException();
    }
}
