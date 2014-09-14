<?php

namespace Concise\Mock;

use Concise\TestCase;
use Concise\Services\NumberToTimesConverter;
use Concise\Services\ValueRenderer;

class MockManager
{
    protected $mocks = array();

    protected $testCase;

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
        );
    }

    protected function validateSingleWith(array $rule, $actualTimes, $method)
    {
        if ($rule['times'] == $actualTimes) {
            return;
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

    protected function validateMultiWith($method, array $rule, array $mock)
    {
        $callGraph = array();
        foreach ($mock['instance']->getCallsForMethod($method) as $call) {
            $key = md5(json_encode($call));
            if (!array_key_exists($key, $callGraph)) {
                $callGraph[$key] = 0;
            }
            ++$callGraph[$key];
        }
        $key = md5(json_encode($rule['with']));
        if (!array_key_exists($key, $callGraph)) {
            $this->validateSingleWith($rule, 0, $method);
        }
        $this->validateSingleWith($rule, $callGraph[$key], $method);
    }

    protected function validateExpectation($mock, $method, array $rule)
    {
        if (null === $rule['with']) {
            $this->validateSingleWith($rule, count($mock['instance']->getCallsForMethod($method)), $method);
        } else {
            $this->validateMultiWith($method, $rule, $mock);
        }
        $this->testCase->assert(true);
    }

    protected function validateMock(array $mock)
    {
        foreach ($mock['mockBuilder']->getRules() as $method => $methodWiths) {
            foreach ($methodWiths as $withKey => $rule) {
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
}
