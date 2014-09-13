<?php

namespace Concise\Console\ResultPrinter;

use Concise\TestCase;
use PHPUnit_Runner_BaseTestRunner;
use Exception;

class DefaultResultPrinterStub extends DefaultResultPrinter
{
    public function getWidth()
    {
        return $this->width;
    }

    public function getIssueNumber()
    {
        return $this->issueNumber;
    }

    public function update()
    {
    }

    public function write($buffer)
    {
    }
}

class DefaultResultPrinterTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->resultPrinter = new DefaultResultPrinterStub();
    }

    public function testWillGetConsoleWidthOnStartup()
    {
        $this->assert($this->resultPrinter->getWidth(), equals, exec('tput cols'));
    }

    public function testFirstIssueNumberIsOne()
    {
        $this->assert($this->resultPrinter->getIssueNumber(), equals, 1);
    }

    public function testEndTestWillIncrementIssueNumber()
    {
        $test = $this->mock('PHPUnit_Framework_TestCase')
                     ->stub(array('getName' => ''))
                     ->done();
        $exception = $this->mock('Exception')->done();
        $this->resultPrinter->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, $test, 0, $exception);
        $this->assert($this->resultPrinter->getIssueNumber(), equals, 2);
    }

    public function testEndTestWillNotIncrementIssueNumberOnSuccess()
    {
        $test = $this->mock('PHPUnit_Framework_TestCase')
                     ->stub(array('getName' => ''))
                     ->done();
        $this->resultPrinter->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_PASSED, $test, 0, null);
        $this->assert($this->resultPrinter->getIssueNumber(), equals, 1);
    }

    public function testEndTestWillUpdateProgress()
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                              ->expects('update')
                              ->done();
        $test = $this->mock('PHPUnit_Framework_TestCase')
                     ->stub(array('getName' => ''))
                     ->done();
        $resultPrinter->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_PASSED, $test, 0, null);
    }

    public function testUpdateWillPrintProgress()
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                              ->expose('update')
                              ->expect('write')
                              ->done();
        $resultPrinter->update();
    }

    public function testStartSuiteWillUpdateProgress()
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                              ->expects('update')
                              ->done();
        $suite = $this->niceMock('PHPUnit_Framework_TestSuite')
                      ->stub(array('getName' => ''))
                      ->done();
        $resultPrinter->startTestSuite($suite);
    }

    public function testEndWillUpdateProgress()
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                              ->expects('update')
                              ->stub('write')
                              ->done();
        $resultPrinter->end();
    }

    public function testSkippedItemsAreNotPrintedWhenVerboseIsTurnedOff()
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                              ->expect('appendTextAbove')->never()
                              ->expose('add')
                              ->done();
        $test = $this->niceMock('PHPUnit_Framework_TestCase')
                     ->stub(array('getName' => ''))
                     ->done();
        $resultPrinter->add(PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED, $test, new Exception());
    }

    public function testSkippedItemsArePrintedWhenVerboseIsTurnedOn()
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                              ->expect('appendTextAbove')
                              ->expose('add')
                              ->done();
        $resultPrinter->setVerbose(true);
        $test = $this->niceMock('PHPUnit_Framework_TestCase')
                     ->stub(array('getName' => ''))
                     ->done();
        $resultPrinter->add(PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED, $test, new Exception());
    }
}
