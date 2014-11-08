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

/**
 * @group ci
 */
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
                     ->get();
        $exception = $this->mock('Exception')->get();
        $this->resultPrinter->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, $test, 0, $exception);
        $this->assert($this->resultPrinter->getIssueNumber(), equals, 2);
    }

    public function testEndTestWillNotIncrementIssueNumberOnSuccess()
    {
        $test = $this->mock('PHPUnit_Framework_TestCase')
                     ->stub(array('getName' => ''))
                     ->get();
        $this->resultPrinter->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_PASSED, $test, 0, null);
        $this->assert($this->resultPrinter->getIssueNumber(), equals, 1);
    }

    public function testEndTestWillUpdateProgress()
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                              ->expects('update')
                              ->get();
        $test = $this->mock('PHPUnit_Framework_TestCase')
                     ->stub(array('getName' => ''))
                     ->get();
        $resultPrinter->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_PASSED, $test, 0, null);
    }

    public function testUpdateWillPrintProgress()
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                              ->expose('update')
                              ->expect('write')
                              ->get();
        $resultPrinter->update();
    }

    public function testStartSuiteWillUpdateProgress()
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                              ->expects('update')
                              ->get();
        $suite = $this->niceMock('PHPUnit_Framework_TestSuite')
                      ->stub(array('getName' => ''))
                      ->get();
        $resultPrinter->startTestSuite($suite);
    }

    public function testEndWillUpdateProgress()
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                              ->expects('update')
                              ->stub('write')
                              ->get();
        $resultPrinter->end();
    }

    public function verboseDataSet()
    {
        $show = 1;
        $hide = 0;

        return array(
            array(PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED,    true,  $show),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED,    false, $hide),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE, true,  $show),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE, false, $hide),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE,    true,  $show),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE,    false, $show),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_ERROR,      true,  $show),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_ERROR,      false, $show),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_RISKY,      true,  $show),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_RISKY,      false, $hide),
        );
    }

    /**
     * @dataProvider verboseDataSet
     */
    public function testVerbosePrintsIssues($status, $isVerbose, $willBePrinted)
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                              ->expect('appendTextAbove')->exactly($willBePrinted)
                              ->expose('add')
                              ->get();
        $resultPrinter->setVerbose($isVerbose);
        $test = $this->niceMock('PHPUnit_Framework_TestCase')
                     ->stub(array('getName' => ''))
                     ->get();
        $resultPrinter->add($status, $test, new Exception());
    }

    public function testHasUpdatedIsFalseByDefault()
    {
        $this->assert($this->getProperty($this->resultPrinter, 'hasUpdated'), is_false);
    }

    public function testHasUpdatedIsTrueAfterUpdateIsCalled()
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
            ->stub('write')
            ->get();
        $resultPrinter->update();
        $this->assert($this->getProperty($resultPrinter, 'hasUpdated'), is_true);
    }
}
