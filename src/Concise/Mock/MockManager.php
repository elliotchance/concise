<?php

namespace Concise\Mock;

use Concise\Core\TestCase;
use Concise\Core\ValueRenderer;
use PHPUnit_Framework_AssertionFailedError;

class MockManager
{
    /**
     * @var array
     */
    protected static $mocks = array();

    /**
     * @var TestCase
     */
    protected $testCase;

    /**
     * @var array
     */
    protected $callGraph = array();

    /**
     * @var array
     */
    protected $argumentsForCallKey = array();

    public function __construct(TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    /**
     * @param MockBuilder $mockBuilder
     * @param object      $mockInstance
     */
    public function addMockInstance(MockBuilder $mockBuilder, $mockInstance)
    {
        self::$mocks[] = array(
            'mockBuilder' => $mockBuilder,
            'instance' => $mockInstance,
            'validated' => false,
        );
    }

    protected function didReceive()
    {
        if (0 === count($this->callGraph)) {
            return '';
        }

        $r = " Did receive:";
        $converter = new NumberToTimesConverter();
        foreach ($this->argumentsForCallKey as $key => $args) {
            $r .= "\n\n" . $converter->convert($this->callGraph[$key]) .
                ": {$args['method']}(" . $this->renderArguments($args['args']) .
                ")";
        }
        return $r;
    }

    /**
     * @param array  $rule
     * @param int    $actualTimes
     * @param string $method
     * @return null
     */
    protected function validateSingleWith(array $rule, $actualTimes, $method)
    {
        if ($rule['times'] == $actualTimes) {
            return null;
        }
        $args = $this->renderArguments($rule['with']);
        $converter = new NumberToTimesConverter();
        $msg = sprintf(
            "Expected $method(%s) to be called %s, but it was called %s.%s",
            $args,
            $converter->convert($rule['times']),
            $converter->convert($actualTimes),
            $this->didReceive()
        );
        throw new \PHPUnit_Framework_AssertionFailedError($msg);
    }

    protected function getKeyForCall(
        $methodName,
        array $arguments,
        array $expected
    ) {
        $count = count($expected);
        for ($i = 0; $i < $count; ++$i) {
            if ($expected[$i] === TestCase::ANYTHING) {
                $arguments[$i] = TestCase::ANYTHING;
            }
        }

        return md5($methodName . json_encode($arguments));
    }

    protected function incrementCallGraphForCall(
        $methodName,
        array $call,
        array $expected
    ) {
        $key = $this->getKeyForCall($methodName, $call, $expected);
        if (!array_key_exists($key, $this->callGraph)) {
            $this->callGraph[$key] = 0;
            $this->argumentsForCallKey[$key] = array(
                'method' => $methodName,
                'args' => $call,
            );
        }
        ++$this->callGraph[$key];
    }

    protected function validateMultiWith($method, array $rule, array $mock)
    {
        /** @var $instance \Concise\Mock\MockInterface */
        $instance = $mock['instance'];
        foreach ($instance->getCallsForMethod($method) as $call) {
            $this->incrementCallGraphForCall($method, $call, $rule['with']);
        }

        $key = $this->getKeyForCall($method, $rule['with'], $rule['with']);
        if (!array_key_exists($key, $this->callGraph)) {
            $this->validateSingleWith($rule, 0, $method);
        } else {
            $this->validateSingleWith($rule, $this->callGraph[$key], $method);
        }
    }

    protected function resetCallGraph()
    {
        $this->callGraph = array();
        $this->argumentsForCallKey = array();
    }

    protected function validateExpectation($mock, $method, array $rule)
    {
        $this->resetCallGraph();
        if (null === $rule['with']) {
            /** @var $instance \Concise\Mock\MockInterface */
            $instance = $mock['instance'];
            $this->validateSingleWith(
                $rule,
                count($instance->getCallsForMethod($method)),
                $method
            );
        } else {
            $this->validateMultiWith($method, $rule, $mock);
        }
        $this->testCase->assertTrue(true);
    }

    /**
     * @param array $mock
     * @return null
     */
    protected function validateMock(array &$mock)
    {
        if ($mock['validated']) {
            return null;
        }
        $mock['validated'] = true;

        /** @var $mockBuilder \Concise\Mock\MockBuilder */
        $mockBuilder = $mock['mockBuilder'];
        foreach ($mockBuilder->getRules() as $method => $methodWiths) {
            foreach ($methodWiths as $rule) {
                // Negative times means it is a stub.
                if ($rule['times'] < 0) {
                    continue;
                }

                $this->validateExpectation($mock, $method, $rule);
            }
        }

        return null;
    }

    public function validateMocks()
    {
        foreach (self::$mocks as &$mock) {
            $this->validateMock($mock);
        }
        self::$mocks = array();
    }

    protected function renderArguments(array $args = null)
    {
        if (null === $args) {
            return '';
        }

        $valueRenderer = new ValueRenderer();

        return $valueRenderer->renderAll($args);
    }

    /**
     * @return array
     */
    public static function getMocks()
    {
        return self::$mocks;
    }

    public function validateMockByInstance(MockInterface $mock)
    {
        foreach (self::$mocks as &$m) {
            if ($mock === $m['instance']) {
                if ($m['validated']) {
                    throw new PHPUnit_Framework_AssertionFailedError(
                        'You cannot assert a mock more than once.'
                    );
                }
                return $this->validateMock($m);
            }
        }

        throw new PHPUnit_Framework_AssertionFailedError(
            'No such mock in mock manager.'
        );
    }
}
