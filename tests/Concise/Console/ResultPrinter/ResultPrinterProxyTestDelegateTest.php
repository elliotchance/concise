<?php

namespace Concise\Console\ResultPrinter;

use Concise\TestCase;
use Exception;
use PHPUnit_Runner_BaseTestRunner;

class ResultPrinterProxyTestDelegateTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->test = $this->mock('PHPUnit_Framework_Test')->get();
        $this->e = $this->mock('Exception')->get();
    }

    protected function getProxyThatExpectsStatus($expectedStatus)
    {
        $resultPrinter = $this->mock('Concise\Console\ResultPrinter\AbstractResultPrinter')
                              ->expect('endTest')->with($expectedStatus, $this->test, 0.1, $this->e)
                              ->get();

        return new ResultPrinterProxy($resultPrinter);
    }

    public function testAddFailureWillCallResultPrinter()
    {
        $this->e = $this->mock('PHPUnit_Framework_AssertionFailedError')->get();
        $proxy = $this->getProxyThatExpectsStatus(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE);
        $proxy->addFailure($this->test, $this->e, 0.1);
    }

    public function testAddErrorWillCallResultPrinter()
    {
        $proxy = $this->getProxyThatExpectsStatus(PHPUnit_Runner_BaseTestRunner::STATUS_ERROR);
        $proxy->addError($this->test, $this->e, 0.1);
    }

    public function testAddIncompleteWillCallResultPrinter()
    {
        $proxy = $this->getProxyThatExpectsStatus(PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE);
        $proxy->addIncompleteTest($this->test, $this->e, 0.1);
    }

    public function testAddSkippedWillCallResultPrinter()
    {
        $proxy = $this->getProxyThatExpectsStatus(PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED);
        $proxy->addSkippedTest($this->test, $this->e, 0.1);
    }

    public function testAddRiskyWillCallResultPrinter()
    {
        $proxy = $this->getProxyThatExpectsStatus(PHPUnit_Runner_BaseTestRunner::STATUS_RISKY);
        $proxy->addRiskyTest($this->test, $this->e, 0.1);
    }
}
