<?php

namespace Concise\Mock;

use Concise\Core\TestCase;
use Exception;

class CombinationMockClass
{
    public $constructorRun = false;

    protected $hidden = 'foo';

    private /** @noinspection PhpUnusedPrivateFieldInspection */
        $secret = 'bar';

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

    /** @noinspection PhpUnusedPrivateMethodInspection */
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

    public function myWithMethodDefaults($a, $b = 'foo', $c = 'baz')
    {
    }

    public function __clone()
    {
        throw new Exception("Did clone.");
    }
}

abstract class CombinationMockAbstractClass
{
    public $constructorRun = false;

    protected $hidden = 'foo';

    private /** @noinspection PhpUnusedPrivateFieldInspection */
        $secret = 'bar';

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

    /** @noinspection PhpUnusedPrivateMethodInspection */
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

    public function myWithMethodDefaults($a, $b = 'foo', $c = 'baz')
    {
    }

    public function __clone()
    {
        throw new Exception("Did clone.");
    }
}

interface CombinationMockedInterface
{
    public function myMethod();

    public function mySecondMethod();

    public static function myStaticMethod();

    public function myWithMethod($a);

    public function myAbstractMethod();

    public function myWithMethodDefaults($a, $b = 'foo', $c = 'baz');
}

final class CombinationMockFinalClass
{
    public $constructorRun = false;

    protected $hidden = 'foo';

    private /** @noinspection PhpUnusedPrivateFieldInspection */
        $secret = 'bar';

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

    /** @noinspection PhpUnusedPrivateMethodInspection */
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

    public function myWithMethodDefaults($a, $b = 'foo', $c = 'baz')
    {
    }

    public function __clone()
    {
        throw new Exception("Did clone.");
    }
}

/**
 * @group mocking
 */
abstract class AbstractBuilderTestCase extends TestCase
{
    const MOCK_CLASS = 1;

    const MOCK_ABSTRACT_CLASS = 2;

    const MOCK_INTERFACE = 3;

    const NICE_MOCK_CLASS = 4;

    const NICE_MOCK_ABSTRACT_CLASS = 5;

    const MOCK_PARTIAL = 6;

    const NICE_MOCK_FINAL_CLASS = 7;

    const MOCK_FINAL_CLASS = 8;

    public function mockBuilders()
    {
        return array(
            'mock class' => array(
                $this->mock(
                    '\Concise\Mock\CombinationMockClass',
                    array(1, 2)
                ),
                self::MOCK_CLASS
            ),
            'mock abstract class' => array(
                $this->mock(
                    '\Concise\Mock\CombinationMockAbstractClass',
                    array(1, 2)
                ),
                self::MOCK_ABSTRACT_CLASS
            ),
            'mock interface' => array(
                $this->mock(
                    '\Concise\Mock\CombinationMockedInterface',
                    array(1, 2)
                ),
                self::MOCK_INTERFACE
            ),
        );
    }

    public function niceMockBuilders()
    {
        return array(
            'nice mock class' => array(
                $this->niceMock(
                    '\Concise\Mock\CombinationMockClass',
                    array(1, 2)
                ),
                self::NICE_MOCK_CLASS
            ),
            'nice mock abstract class' => array(
                $this->niceMock(
                    '\Concise\Mock\CombinationMockAbstractClass',
                    array(1, 2)
                ),
                self::NICE_MOCK_ABSTRACT_CLASS
            ),
            'partial mock' => array(
                $this->partialMock(
                    new CombinationMockClass(1, 2)
                ),
                self::MOCK_PARTIAL
            ),
        );
    }

    public function abstractBuilders()
    {
        return array(
            'mock abstract class' => array(
                $this->mock(
                    '\Concise\Mock\CombinationMockAbstractClass',
                    array(1, 2)
                ),
                self::MOCK_ABSTRACT_CLASS
            ),
            'nice mock abstract class' => array(
                $this->niceMock(
                    '\Concise\Mock\CombinationMockAbstractClass',
                    array(1, 2)
                ),
                self::NICE_MOCK_ABSTRACT_CLASS
            ),
        );
    }

    public function finalBuilders()
    {
        return array(
            'mock final class' => array(
                $this->mock(
                    '\Concise\Mock\CombinationMockFinalClass',
                    array(1, 2)
                ),
                self::MOCK_FINAL_CLASS
            ),
            'nice mock final class' => array(
                $this->niceMock(
                    '\Concise\Mock\CombinationMockFinalClass',
                    array(1, 2)
                ),
                self::NICE_MOCK_FINAL_CLASS
            ),
        );
    }

    public function allBuilders()
    {
        return $this->mockBuilders() + $this->niceMockBuilders();
    }

    protected function expectFailure($message, $exceptionClass = '\Exception')
    {
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($message);
    }

    protected function notApplicable()
    {
        return $this->assert(true)->isTrue;
    }
}
