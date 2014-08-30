<?php

namespace Concise\Console\ResultPrinter;

use Exception;
use PHPUnit_Framework_AssertionFailedError;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestResult;
use PHPUnit_Framework_TestSuite;
use Concise\Console\TestRunner\TestResultDelegateInterface;
use PHPUnit_Runner_BaseTestRunner;

class ResultPrinterProxy extends \PHPUnit_TextUI_ResultPrinter
{
    protected $resultPrinter;

    protected $startedTestSuite = 0;

    protected $totalSuccesses = 0;

    public function __construct(TestResultDelegateInterface $resultPrinter = null)
    {
        parent::__construct();
        if ($resultPrinter) {
            $this->resultPrinter = $resultPrinter;
        } else {
            $this->resultPrinter = new DefaultResultPrinter();
        }
    }

    public function getResultPrinter()
    {
        return $this->resultPrinter;
    }

    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
    {
        ++$this->getResultPrinter()->failureCount;
        $this->getResultPrinter()->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, $test, $time, $e);
    }

    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        ++$this->getResultPrinter()->errorCount;
        $this->getResultPrinter()->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_ERROR, $test, $time, $e);
    }

    public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        ++$this->getResultPrinter()->incompleteCount;
        $this->getResultPrinter()->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE, $test, $time, $e);
    }

    public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        ++$this->getResultPrinter()->skippedCount;
        $this->getResultPrinter()->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED, $test, $time, $e);
    }

    public function addRiskyTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        ++$this->getResultPrinter()->riskyCount;
        $this->getResultPrinter()->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_RISKY, $test, $time, $e);
    }

    protected function printHeader()
    {
    }

    protected function printDefects(array $defects, $type)
    {
    }

    protected function printDefect(PHPUnit_Framework_TestFailure $defect, $count)
    {
    }

    protected function printFooter(PHPUnit_Framework_TestResult $result)
    {
    }

    public function write($buffer)
    {
    }

    public function printResult(PHPUnit_Framework_TestResult $result)
    {
    }

    public function endTest(PHPUnit_Framework_Test $test, $time)
    {
        ++$this->getResultPrinter()->testCount;
        if (is_subclass_of($test, "PHPUnit_Framework_TestCase")) {
            $this->getResultPrinter()->assertionCount += $test->getNumAssertions();
        } else {
            ++$this->getResultPrinter()->assertionCount;
        }

        if ($this->totalSuccesses === $this->getResultPrinter()->getSuccessCount()) {
            $this->getResultPrinter()->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_PASSED, $test, $time);
        }
        $this->totalSuccesses = $this->getResultPrinter()->getSuccessCount();
    }

    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        if ($this->startedTestSuite === 0) {
            $this->getResultPrinter()->totalTestCount = count($suite);
        }

        ++$this->startedTestSuite;
        $this->getResultPrinter()->startTestSuite($suite);
    }

    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        $this->getResultPrinter()->endTestSuite($suite);
        --$this->startedTestSuite;

        if ($this->startedTestSuite === 0) {
            $this->getResultPrinter()->end();
        }
    }
}
