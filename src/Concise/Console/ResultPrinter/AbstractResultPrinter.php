<?php

namespace Concise\Console\ResultPrinter;

use Exception;
use PHPUnit_Framework_TestSuite;
use Concise\Console\TestRunner\TestResultDelegateInterface;
use PHPUnit_Framework_Test;

abstract class AbstractResultPrinter implements TestResultDelegateInterface, StatisticsInterface
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
        return $this->getTestCount() - $this->getFailureCount() - $this->getErrorCount()
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

    public function endTest($status, PHPUnit_Framework_Test $test, $time, Exception $e = null)
    {
    }

    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
    }

    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
    }

    public function write($string)
    {
        echo $string;
    }

    public function end()
    {
    }

    public function setVerbose($verbose)
    {
    }

    public function isVerbose()
    {
        return false;
    }
}
