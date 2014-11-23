<?php

namespace Concise\Mock;

use Concise\TestCase;
use Concise\Services\NumberToTimesConverter;
use Concise\Services\ValueRenderer;
use Concise\Mock\MockInterface;

class MockManager
{
    /**
     * @var array
     */
    protected $mocks = array();

    /**
     * @var \Concise\TestCase
     */
    protected $testCase;

    /**
     * @var array
     */
    protected $callGraph = array();

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
        $this->mocks[] = array(
            'mockBuilder' => $mockBuilder,
            'instance' => $mockInstance,
            'validated' => false,
        );
    }

    /**
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
            "Expected $method(%s) to be called %s, but it was called %s.",
            $args,
            $converter->convert($rule['times']),
            $converter->convert($actualTimes)
        );
        throw new \PHPUnit_Framework_AssertionFailedError($msg);
    }

    protected function getKeyForCall($methodName, array $arguments, array $expected)
    {
        for ($i = 0; $i < count($expected); ++$i) {
            if ($expected[$i] === TestCase::ANYTHING) {
                $arguments[$i] = TestCase::ANYTHING;
            }
        }

        return md5($methodName . json_encode($arguments));
    }

    protected function incrementCallGraphForCall($methodName, array $call, array $expected)
    {
        $key = $this->getKeyForCall($methodName, $call, $expected);
        if (!array_key_exists($key, $this->callGraph)) {
            $this->callGraph[$key] = 0;
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
            return $this->validateSingleWith($rule, 0, $method);
        }
        $this->validateSingleWith($rule, $this->callGraph[$key], $method);
    }

    protected function validateExpectation($mock, $method, array $rule)
    {
        if (null === $rule['with']) {
            /** @var $instance \Concise\Mock\MockInterface */
            $instance = $mock['instance'];
            $this->validateSingleWith($rule, count($instance->getCallsForMethod($method)), $method);
        } else {
            $this->validateMultiWith($method, $rule, $mock);
        }
        $this->testCase->assert(true);
    }

    protected function validateMock(array &$mock)
    {
        if ($mock['validated']) {
            return;
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
    }

    public function validateMocks()
    {
        foreach ($this->mocks as $mock) {
            $this->validateMock($mock);
        }
    }

    protected function renderArguments(array $args = null)
    {
        if (null === $args) {
            return '';
        }

        $valueRenderer = new ValueRenderer();

        return $valueRenderer->renderAll($args);
    }

    public function getMocks()
    {
        return $this->mocks;
    }

    public function validateMockByInstance(MockInterface $mock)
    {
        $this->validateMock(array_pop($this->mocks));
    }
}
