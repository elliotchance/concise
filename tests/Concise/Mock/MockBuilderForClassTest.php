<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockClass
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

    static public function myStaticMethod()
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
}
