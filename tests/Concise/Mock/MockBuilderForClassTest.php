<?php

namespace Concise\Mock;

class MockClass
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

class MockBuilderForClassTest extends AbstractMockBuilderTestCase
{
    public function getClassName()
    {
        return '\Concise\Mock\MockClass';
    }

    public function testMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate()
    {
        $this->notApplicable();
    }

    public function testCallingAnAbstractMethodWithNoRuleThrowsException()
    {
        $this->notApplicable();
    }

    public function testCallingAnAbstractMethodOnANiceMockWithNoRuleThrowsException()
    {
        $this->notApplicable();
    }

    public function testAbstractMethodsCanHaveRulesAttached()
    {
        $this->notApplicable();
    }
}
