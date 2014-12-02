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

    public function testMockImplementsMockInterface()
    {
        $this->expectFailure('Class Concise\Mock\MockFinalClass is final so it cannot be mocked.');
        parent::testMockImplementsMockInterface();
    }
}
