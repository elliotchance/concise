<?php

namespace Concise\Console;

use Concise\TestCase;
use Exception;
use PHPUnit_Runner_BaseTestRunner;

class AbstractResultPrinterTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->resultPrinter = $this->niceMock('Concise\Console\AbstractResultPrinter')->done();
    }

    public function testResultPrinterImplementsResultPrinterInterface()
    {
        $this->assert($this->resultPrinter, instance_of, 'Concise\Console\ResultPrinterInterface');
    }

    public function testResultPrinterExtendsAbstractResultPrinter()
    {
        $this->assert($this->resultPrinter, instance_of, 'Concise\Console\AbstractResultPrinter');
    }

    public function testDefaultSuccessCountIsZero()
    {
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 0);
    }

    public function testDefaultFailureCountIsZero()
    {
        $this->assert($this->resultPrinter->getFailureCount(), exactly_equals, 0);
    }

    public function testDefaultErrorCountIsZero()
    {
        $this->assert($this->resultPrinter->getErrorCount(), exactly_equals, 0);
    }

    public function testDefaultIncompleteCountIsZero()
    {
        $this->assert($this->resultPrinter->getIncompleteCount(), exactly_equals, 0);
    }

    public function testDefaultRiskyCountIsZero()
    {
        $this->assert($this->resultPrinter->getRiskyCount(), exactly_equals, 0);
    }

    public function testDefaultSkippedCountIsZero()
    {
        $this->assert($this->resultPrinter->getSkippedCount(), exactly_equals, 0);
    }

    public function testDefaultTestCountIsZero()
    {
        $this->assert($this->resultPrinter->getTestCount(), exactly_equals, 0);
    }

    public function testDefaultTotalTestCountIsZero()
    {
        $this->assert($this->resultPrinter->getTotalTestCount(), exactly_equals, 0);
    }

    public function testDefaultAssertionCountIsZero()
    {
        $this->assert($this->resultPrinter->getAssertionCount(), exactly_equals, 0);
    }

    public function testSuccessCountIsTheTotalTestCount()
    {
        $this->resultPrinter->totalTestCount = 20;
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 20);
    }

    public function testSuccessCountWillNotIncludeSkipped()
    {
        $this->resultPrinter->totalTestCount = 20;
        $this->resultPrinter->skippedCount = 10;
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 10);
    }

    public function testSuccessCountWillNotIncludeFailures()
    {
        $this->resultPrinter->totalTestCount = 20;
        $this->resultPrinter->failureCount = 10;
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 10);
    }

    public function testSuccessCountWillNotIncludeErrors()
    {
        $this->resultPrinter->totalTestCount = 20;
        $this->resultPrinter->errorCount = 10;
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 10);
    }

    public function testSuccessCountWillNotIncludeIncompleteTests()
    {
        $this->resultPrinter->totalTestCount = 20;
        $this->resultPrinter->incompleteCount = 10;
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 10);
    }

    public function testSuccessCountWillNotIncludeRiskyTests()
    {
        $this->resultPrinter->totalTestCount = 20;
        $this->resultPrinter->riskyCount = 10;
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 10);
    }

    public function testAddSuccessCallsAdd()
    {
        $testCase = $this->mock('PHPUnit_Framework_TestCase')
                         ->stub(['getNumAssertions' => 1])
                         ->done();

        $resultPrinter = $this->niceMock('Concise\Console\AbstractResultPrinter')
                              ->expect('add')->with(PHPUnit_Runner_BaseTestRunner::STATUS_PASSED, $testCase, 0.1)
                              ->done();
        $resultPrinter->addSuccess($testCase, 0.1);
    }

    public function testAddSkippedCallsAdd()
    {
        $testCase = $this->mock('PHPUnit_Framework_TestCase')
                         ->stub(['getNumAssertions' => 1])
                         ->done();
        $exception = new Exception();

        $resultPrinter = $this->niceMock('Concise\Console\AbstractResultPrinter')
                              ->expect('add')->with(PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED, $testCase, 0.1, $exception)
                              ->done();
        $resultPrinter->addSkippedTest($testCase, $exception, 0.1);
    }
}
