<?php

namespace Concise\Console\ResultPrinter;

use Concise\Core\TestCase;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Runner\BaseTestRunner;

class ResultPrinterProxyTestDelegateTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->test = $this->mock(Test::class)->get();
        $this->e = $this->mock('Exception')->get();
    }

    protected function getProxyThatExpectsStatus($expectedStatus)
    {
        $resultPrinter =
            $this->mock('Concise\Console\ResultPrinter\AbstractResultPrinter')
                ->expect('endTest')
                ->with($expectedStatus, $this->test, 0.1, $this->e)
                ->get();

        return new ResultPrinterProxy($resultPrinter);
    }

    public function testAddFailureWillCallResultPrinter()
    {
        $this->e = $this->mock(AssertionFailedError::class)->get();
        $proxy = $this->getProxyThatExpectsStatus(
            BaseTestRunner::STATUS_FAILURE
        );
        $proxy->addFailure($this->test, $this->e, 0.1);
    }

    public function testAddErrorWillCallResultPrinter()
    {
        $proxy = $this->getProxyThatExpectsStatus(
            BaseTestRunner::STATUS_ERROR
        );
        $proxy->addError($this->test, $this->e, 0.1);
    }

    public function testAddIncompleteWillCallResultPrinter()
    {
        $proxy = $this->getProxyThatExpectsStatus(
            BaseTestRunner::STATUS_INCOMPLETE
        );
        $proxy->addIncompleteTest($this->test, $this->e, 0.1);
    }

    public function testAddSkippedWillCallResultPrinter()
    {
        $proxy = $this->getProxyThatExpectsStatus(
            BaseTestRunner::STATUS_SKIPPED
        );
        $proxy->addSkippedTest($this->test, $this->e, 0.1);
    }

    public function testAddRiskyWillCallResultPrinter()
    {
        $proxy = $this->getProxyThatExpectsStatus(
            BaseTestRunner::STATUS_RISKY
        );
        $proxy->addRiskyTest($this->test, $this->e, 0.1);
    }
}
