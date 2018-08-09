<?php

namespace Concise\Console\ResultPrinter;

use Concise\Core\VirtualTestSuiteInterface;
use Exception;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestFailure;
use PHPUnit\Framework\TestResult;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Runner\BaseTestRunner;
use PHPUnit\TextUI\ResultPrinter;

class ResultPrinterProxy extends ResultPrinter
{
    /**
     * @var AbstractResultPrinter
     */
    protected $resultPrinter;

    /**
     * @var integer
     */
    protected $startedTestSuite = 0;

    /**
     * @var integer
     */
    protected $totalSuccesses = 0;

    /**
     * @param AbstractResultPrinter $resultPrinter
     */
    public function __construct(AbstractResultPrinter $resultPrinter)
    {
        parent::__construct();
        $this->resultPrinter = $resultPrinter;
    }

    /**
     * @return AbstractResultPrinter
     */
    public function getResultPrinter()
    {
        return $this->resultPrinter;
    }

    public function addFailure(
        Test $test,
        AssertionFailedError $e,
        $time
    ) {
        ++$this->getResultPrinter()->failureCount;
        $this->getResultPrinter()->endTest(
            BaseTestRunner::STATUS_FAILURE,
            $test,
            $time,
            $e
        );
    }

    public function addError(Test $test, Exception $e, $time)
    {
        ++$this->getResultPrinter()->errorCount;
        $this->getResultPrinter()->endTest(
            BaseTestRunner::STATUS_ERROR,
            $test,
            $time,
            $e
        );
    }

    public function addIncompleteTest(
        Test $test,
        Exception $e,
        $time
    ) {
        ++$this->getResultPrinter()->incompleteCount;
        $this->getResultPrinter()->endTest(
            BaseTestRunner::STATUS_INCOMPLETE,
            $test,
            $time,
            $e
        );
    }

    public function addSkippedTest(
        Test $test,
        Exception $e,
        $time
    ) {
        ++$this->getResultPrinter()->skippedCount;
        $this->getResultPrinter()->endTest(
            BaseTestRunner::STATUS_SKIPPED,
            $test,
            $time,
            $e
        );
    }

    public function addRiskyTest(
        Test $test,
        Exception $e,
        $time
    ) {
        ++$this->getResultPrinter()->riskyCount;
        $this->getResultPrinter()->endTest(
            BaseTestRunner::STATUS_RISKY,
            $test,
            $time,
            $e
        );
    }

    protected function printHeader()
    {
    }

    protected function printDefects(array $defects, $type)
    {
    }

    protected function printDefect(TestFailure $defect, $count)
    {
    }

    protected function printFooter(TestResult $result)
    {
    }

    public function write($buffer)
    {
        if (strpos($buffer, 'Code Coverage Report') === false) {
            return null;
        }
        echo $buffer;
    }

    public function printResult(TestResult $result)
    {
    }

    public function endTest(Test $test, $time)
    {
        ++$this->getResultPrinter()->testCount;
        if (is_subclass_of($test, "TestCase")) {
            /** @var $test \TestCase */
            $this->getResultPrinter()->assertionCount +=
                $test->getNumAssertions();
        } else {
            ++$this->getResultPrinter()->assertionCount;
        }

        if ($this->totalSuccesses <
            $this->getResultPrinter()->getSuccessCount()
        ) {
            $this->getResultPrinter()->endTest(
                BaseTestRunner::STATUS_PASSED,
                $test,
                $time
            );
        }
        $this->totalSuccesses = $this->getResultPrinter()->getSuccessCount();
    }

    public function startTestSuite(TestSuite $suite)
    {
        $resultPrinter = $this->getResultPrinter();
        if ($this->startedTestSuite === 0) {
            if ($suite instanceof VirtualTestSuiteInterface) {
                // Custom test suite loaders may instantiate an instance of
                // VirtualTestSuiteInterface for the test suite. This is to
                // allow the test suites to return an explicit test count rather
                // than relying on the native mechanics of PHPUnit to count the
                // methods that start with "test".
                $resultPrinter->totalTestCount = $suite->getRealCount();
            } elseif ($suite->testAt(0) instanceof VirtualTestSuiteInterface) {
                // Alternatively we may be forced to use the standard PHPUnit
                // suite but we can wrap the virtual test case inside it.

                $test = $suite->testAt(0);
                $resultPrinter->totalTestCount = $test->getRealCount();
            } else {
                // Fall back to the default option which is relying on the
                // native PHPUnit classes to report their count.
                $resultPrinter->totalTestCount = count($suite);
            }
        }

        ++$this->startedTestSuite;
        $resultPrinter->startTestSuite($suite);
    }

    public function endTestSuite(TestSuite $suite)
    {
        $this->getResultPrinter()->endTestSuite($suite);
        --$this->startedTestSuite;

        if ($this->startedTestSuite === 0) {
            $this->getResultPrinter()->end();
        }
    }
}
