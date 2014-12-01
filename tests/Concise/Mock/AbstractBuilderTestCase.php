<?php

namespace Concise\Mock;

use Concise\TestCase;

class CombinationMockClass
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

abstract class CombinationMockAbstractClass
{
    public $constructorRun = false;

    protected $hidden = 'foo';

    private $secret = 'bar';

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

interface CombinationMockedInterface
{
    public function myMethod();

    public function mySecondMethod();

    public static function myStaticMethod();

    public function myWithMethod($a);

    public function myAbstractMethod();
}

/**
 * @group mocking
 */
abstract class AbstractBuilderTestCase extends TestCase
{
    public function mockBuilders()
    {
        return array(
            'mock class' => array($this->mock('\Concise\Mock\CombinationMockClass', array(1, 2)), 'mock class'),
            'mock abstract' => array($this->mock('\Concise\Mock\CombinationMockAbstractClass', array(1, 2)), 'mock abstract'),
            'mock interface' => array($this->mock('\Concise\Mock\CombinationMockedInterface', array(1, 2)), 'mock interface'),
        );
    }

    public function niceMockBuilders()
    {
        return array(
            'nice class' => array($this->niceMock('\Concise\Mock\CombinationMockClass', array(1, 2)), 'nice class'),
            'nice abstract' => array($this->niceMock('\Concise\Mock\CombinationMockAbstractClass', array(1, 2)), 'nice abstract'),
            'partial' => array($this->partialMock(new CombinationMockClass(1, 2)), 'partial'),
        );
    }

    public function allBuilders()
    {
        return $this->mockBuilders() + $this->niceMockBuilders();
    }

    protected function expectFailure($message, $exceptionClass = '\Exception')
    {
        $this->setExpectedException($exceptionClass, $message);
    }
}
