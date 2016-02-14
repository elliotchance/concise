<?php

namespace Concise\Console\ResultPrinter;

use Concise\Core\VirtualTestSuiteInterface;
use Concise\Extensions\Pho\PhoTestCase;
use Exception;
use PHPUnit_Framework_AssertionFailedError;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestFailure;
use PHPUnit_Framework_TestResult;
use PHPUnit_Framework_TestSuite;
use PHPUnit_Runner_BaseTestRunner;
use PHPUnit_TextUI_ResultPrinter;

class ResultPrinterProxy extends PHPUnit_TextUI_ResultPrinter
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
        PHPUnit_Framework_Test $test,
        PHPUnit_Framework_AssertionFailedError $e,
        $time
    ) {
        ++$this->getResultPrinter()->failureCount;
        $this->getResultPrinter()->endTest(
            PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE,
            $test,
            $time,
            $e
        );
    }

    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        ++$this->getResultPrinter()->errorCount;
        $this->getResultPrinter()->endTest(
            PHPUnit_Runner_BaseTestRunner::STATUS_ERROR,
            $test,
            $time,
            $e
        );
    }

    public function addIncompleteTest(
        PHPUnit_Framework_Test $test,
        Exception $e,
        $time
    ) {
        ++$this->getResultPrinter()->incompleteCount;
        $this->getResultPrinter()->endTest(
            PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE,
            $test,
            $time,
            $e
        );
    }

    public function addSkippedTest(
        PHPUnit_Framework_Test $test,
        Exception $e,
        $time
    ) {
        ++$this->getResultPrinter()->skippedCount;
        $this->getResultPrinter()->endTest(
            PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED,
            $test,
            $time,
            $e
        );
    }

    public function addRiskyTest(
        PHPUnit_Framework_Test $test,
        Exception $e,
        $time
    ) {
        ++$this->getResultPrinter()->riskyCount;
        $this->getResultPrinter()->endTest(
            PHPUnit_Runner_BaseTestRunner::STATUS_RISKY,
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

    protected function printDefect(
        PHPUnit_Framework_TestFailure $defect,
        $count
    ) {
    }

    protected function printFooter(PHPUnit_Framework_TestResult $result)
    {
    }

    public function write($buffer)
    {
        if (strpos($buffer, 'Code Coverage Report') === false) {
            return null;
        }
        echo $buffer;
    }

    public function printResult(PHPUnit_Framework_TestResult $result)
    {
    }

    public function endTest(PHPUnit_Framework_Test $test, $time)
    {
        ++$this->getResultPrinter()->testCount;
        if (is_subclass_of($test, "PHPUnit_Framework_TestCase")) {
            /** @var $test \PHPUnit_Framework_TestCase */
            $this->getResultPrinter()->assertionCount +=
                $test->getNumAssertions();
        } else {
            ++$this->getResultPrinter()->assertionCount;
        }

        if ($this->totalSuccesses <
            $this->getResultPrinter()->getSuccessCount()
        ) {
            $this->getResultPrinter()->endTest(
                PHPUnit_Runner_BaseTestRunner::STATUS_PASSED,
                $test,
                $time
            );
        }
        $this->totalSuccesses = $this->getResultPrinter()->getSuccessCount();
    }

    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
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

                /** @var PhoTestCase $test */
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

    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        $this->getResultPrinter()->endTestSuite($suite);
        --$this->startedTestSuite;

        if ($this->startedTestSuite === 0) {
            $this->getResultPrinter()->end();
        }
    }
}
