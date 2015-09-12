<?php

namespace Concise\Console\ResultPrinter;

use Concise\TestCase;

class AbstractResultPrinterTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\AbstractResultPrinter'
        )->get();
    }

    public function testResultPrinterImplementsTestResultDelegateInterface()
    {
        $this->assert($this->resultPrinter)->instanceOf('Concise\Console\TestRunner\TestResultDelegateInterface');
    }

    public function testDefaultSuccessCountIsZero()
    {
        $this->assert($this->resultPrinter->getSuccessCount())->exactlyEquals(0);
    }

    public function testDefaultFailureCountIsZero()
    {
        $this->assert($this->resultPrinter->getFailureCount())->exactlyEquals(0);
    }

    public function testDefaultErrorCountIsZero()
    {
        $this->assert($this->resultPrinter->getErrorCount())->exactlyEquals(0);
    }

    public function testDefaultIncompleteCountIsZero()
    {
        $this->assert($this->resultPrinter->getIncompleteCount())->exactlyEquals(0);
    }

    public function testDefaultRiskyCountIsZero()
    {
        $this->assert($this->resultPrinter->getRiskyCount())->exactlyEquals(0);
    }

    public function testDefaultSkippedCountIsZero()
    {
        $this->assert($this->resultPrinter->getSkippedCount())->exactlyEquals(0);
    }

    public function testDefaultTestCountIsZero()
    {
        $this->assert($this->resultPrinter->getTestCount())->exactlyEquals(0);
    }

    public function testDefaultTotalTestCountIsZero()
    {
        $this->assert($this->resultPrinter->getTotalTestCount())->exactlyEquals(0);
    }

    public function testDefaultAssertionCountIsZero()
    {
        $this->assert($this->resultPrinter->getAssertionCount())->exactlyEquals(0);
    }

    public function testSuccessCountIsTheTestCount()
    {
        $this->resultPrinter->testCount = 20;
        $this->assert($this->resultPrinter->getSuccessCount())->exactlyEquals(20);
    }

    public function testSuccessCountWillNotIncludeSkipped()
    {
        $this->resultPrinter->testCount = 20;
        $this->resultPrinter->skippedCount = 10;
        $this->assert($this->resultPrinter->getSuccessCount())->exactlyEquals(10);
    }

    public function testSuccessCountWillNotIncludeFailures()
    {
        $this->resultPrinter->testCount = 20;
        $this->resultPrinter->failureCount = 10;
        $this->assert($this->resultPrinter->getSuccessCount())->exactlyEquals(10);
    }

    public function testSuccessCountWillNotIncludeErrors()
    {
        $this->resultPrinter->testCount = 20;
        $this->resultPrinter->errorCount = 10;
        $this->assert($this->resultPrinter->getSuccessCount())->exactlyEquals(10);
    }

    public function testSuccessCountWillNotIncludeIncompleteTests()
    {
        $this->resultPrinter->testCount = 20;
        $this->resultPrinter->incompleteCount = 10;
        $this->assert($this->resultPrinter->getSuccessCount())->exactlyEquals(10);
    }

    public function testSuccessCountWillNotIncludeRiskyTests()
    {
        $this->resultPrinter->testCount = 20;
        $this->resultPrinter->riskyCount = 10;
        $this->assert($this->resultPrinter->getSuccessCount())->exactlyEquals(10);
    }

    public function testEndTestReturnsNull()
    {
        $test = $this->mock('PHPUnit_Framework_Test')->get();
        $this->assert($this->resultPrinter->endTest(0, $test, 0.0, null))->isNull;
    }

    public function testEndTestSuiteReturnsNull()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')
            ->disableConstructor()
            ->get();
        $this->assert($this->resultPrinter->endTestSuite($suite))->isNull;
    }

    public function testEndReturnsNull()
    {
        $this->assert($this->resultPrinter->end())->isNull;
    }

    public function testVerbosityCanBeSet()
    {
        $this->assert($this->resultPrinter->setVerbose(false))->isNull;
    }

    public function testDefaultVerboseIsOff()
    {
        $this->assert($this->resultPrinter->isVerbose())->isFalse;
    }

    public function testGetVerbose()
    {
        $this->resultPrinter->setVerbose(true);
        $this->assert($this->resultPrinter->isVerbose())->isTrue;
    }
}
