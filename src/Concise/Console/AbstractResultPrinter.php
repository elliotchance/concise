<?php

namespace Concise\Console;

use Exception;
use PHPUnit_Framework_AssertionFailedError;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestSuite;
use PHPUnit_Runner_BaseTestRunner;

abstract class AbstractResultPrinter implements ResultPrinterInterface
{
    public $failureCount = 0;

    public $errorCount = 0;

    public $incompleteCount = 0;

    public $skippedCount = 0;

    public $riskyCount = 0;

    public $testCount = 0;

    public $totalTestCount = 0;

    public $assertionCount = 0;

    public function getSuccessCount()
    {
        return $this->getTotalTestCount() - $this->getFailureCount() - $this->getErrorCount()
            - $this->getSkippedCount() - $this->getIncompleteCount() - $this->getRiskyCount();
    }

    public function getFailureCount()
    {
        return $this->failureCount;
    }

    public function getErrorCount()
    {
        return $this->errorCount;
    }

    public function getIncompleteCount()
    {
        return $this->incompleteCount;
    }

    public function getRiskyCount()
    {
        return $this->riskyCount;
    }

    public function getSkippedCount()
    {
        return $this->skippedCount;
    }

    public function getTestCount()
    {
        return $this->testCount;
    }

    public function getTotalTestCount()
    {
        return $this->totalTestCount;
    }

    public function getAssertionCount()
    {
        return $this->assertionCount;
    }

    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
    {
        $this->add(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, $test, $time, $e);
    }

    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
    }

    public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
    }

    public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        $this->add(PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED, $test, $time, $e);
    }

    public function addRiskyTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        $this->add(PHPUnit_Runner_BaseTestRunner::STATUS_RISKY, $test, $time, $e);
    }

    public function addSuccess(PHPUnit_Framework_Test $test, $time)
    {
        $this->add(PHPUnit_Runner_BaseTestRunner::STATUS_PASSED, $test, $time);
    }

    public function endTest(PHPUnit_Framework_Test $test, $time)
    {
    }

    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
    }

    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
    }

    public function add($status, PHPUnit_Framework_Test $test, $time, Exception $e = null)
    {
    }

    public function write($string)
    {
        echo $string;
    }

    public function finish()
    {
    }
}
