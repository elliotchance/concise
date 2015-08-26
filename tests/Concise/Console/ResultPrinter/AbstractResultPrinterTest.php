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
        $this->aassert($this->resultPrinter)->instanceOf('Concise\Console\TestRunner\TestResultDelegateInterface');
    }

    public function testDefaultSuccessCountIsZero()
    {
        $this->aassert($this->resultPrinter->getSuccessCount())->exactlyEquals(0);
    }

    public function testDefaultFailureCountIsZero()
    {
        $this->aassert($this->resultPrinter->getFailureCount())->exactlyEquals(0);
    }

    public function testDefaultErrorCountIsZero()
    {
        $this->aassert($this->resultPrinter->getErrorCount())->exactlyEquals(0);
    }

    public function testDefaultIncompleteCountIsZero()
    {
        $this->aassert($this->resultPrinter->getIncompleteCount())->exactlyEquals(0);
    }

    public function testDefaultRiskyCountIsZero()
    {
        $this->aassert($this->resultPrinter->getRiskyCount())->exactlyEquals(0);
    }

    public function testDefaultSkippedCountIsZero()
    {
        $this->aassert($this->resultPrinter->getSkippedCount())->exactlyEquals(0);
    }

    public function testDefaultTestCountIsZero()
    {
        $this->aassert($this->resultPrinter->getTestCount())->exactlyEquals(0);
    }

    public function testDefaultTotalTestCountIsZero()
    {
        $this->aassert($this->resultPrinter->getTotalTestCount())->exactlyEquals(0);
    }

    public function testDefaultAssertionCountIsZero()
    {
        $this->aassert($this->resultPrinter->getAssertionCount())->exactlyEquals(0);
    }

    public function testSuccessCountIsTheTestCount()
    {
        $this->resultPrinter->testCount = 20;
        $this->aassert($this->resultPrinter->getSuccessCount())->exactlyEquals(20);
    }

    public function testSuccessCountWillNotIncludeSkipped()
    {
        $this->resultPrinter->testCount = 20;
        $this->resultPrinter->skippedCount = 10;
        $this->aassert($this->resultPrinter->getSuccessCount())->exactlyEquals(10);
    }

    public function testSuccessCountWillNotIncludeFailures()
    {
        $this->resultPrinter->testCount = 20;
        $this->resultPrinter->failureCount = 10;
        $this->aassert($this->resultPrinter->getSuccessCount())->exactlyEquals(10);
    }

    public function testSuccessCountWillNotIncludeErrors()
    {
        $this->resultPrinter->testCount = 20;
        $this->resultPrinter->errorCount = 10;
        $this->aassert($this->resultPrinter->getSuccessCount())->exactlyEquals(10);
    }

    public function testSuccessCountWillNotIncludeIncompleteTests()
    {
        $this->resultPrinter->testCount = 20;
        $this->resultPrinter->incompleteCount = 10;
        $this->aassert($this->resultPrinter->getSuccessCount())->exactlyEquals(10);
    }

    public function testSuccessCountWillNotIncludeRiskyTests()
    {
        $this->resultPrinter->testCount = 20;
        $this->resultPrinter->riskyCount = 10;
        $this->aassert($this->resultPrinter->getSuccessCount())->exactlyEquals(10);
    }

    public function testEndTestReturnsNull()
    {
        $test = $this->mock('PHPUnit_Framework_Test')->get();
        $this->aassert($this->resultPrinter->endTest(0, $test, 0.0, null))->isNull;
    }

    public function testEndTestSuiteReturnsNull()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')
            ->disableConstructor()
            ->get();
        $this->aassert($this->resultPrinter->endTestSuite($suite))->isNull;
    }

    public function testEndReturnsNull()
    {
        $this->aassert($this->resultPrinter->end())->isNull;
    }

    public function testVerbosityCanBeSet()
    {
        $this->aassert($this->resultPrinter->setVerbose(false))->isNull;
    }

    public function testDefaultVerboseIsOff()
    {
        $this->aassert($this->resultPrinter->isVerbose())->isFalse;
    }

    public function testGetVerbose()
    {
        $this->resultPrinter->setVerbose(true);
        $this->aassert($this->resultPrinter->isVerbose())->isTrue;
    }
}
