<?php

namespace Concise\Console;

use \Concise\TestCase;

class ResultPrinterProxyTest extends TestCase
{
    public function testProxyExtendsPHPUnit()
    {
        $this->assert(new ResultPrinterProxy(), instance_of, 'PHPUnit_TextUI_ResultPrinter');
    }

    public function testGetResultPrinterReturnsAResultPrinterInterface()
    {
        $proxy = new ResultPrinterProxy();
        $this->assert($proxy->getResultPrinter(), instance_of, 'Concise\Console\ResultPrinterInterface');
    }

    public function testResultPrinterIsSetViaConstructor()
    {
        $printer = new ResultPrinter();
        $proxy = new ResultPrinterProxy($printer);
        $this->assert($proxy->getResultPrinter(), is_the_same_as, $printer);
    }

    public function testAddFailureWillIncrementCount()
    {
        $proxy = new ResultPrinterProxy();
        $test = $this->mock('PHPUnit_Framework_Test')->done();
        $e = $this->mock('PHPUnit_Framework_AssertionFailedError')->done();
        $proxy->addFailure($test, $e, 0);
        $this->assert($proxy->getResultPrinter()->getFailureCount(), equals, 1);
    }

    public function testAddErrorWillIncrementCount()
    {
        $proxy = new ResultPrinterProxy();
        $test = $this->mock('PHPUnit_Framework_Test')->done();
        $e = $this->mock('Exception')->done();
        $proxy->addError($test, $e, 0);
        $this->assert($proxy->getResultPrinter()->getErrorCount(), equals, 1);
    }

    public function testAddIncompleteWillIncrementCount()
    {
        $proxy = new ResultPrinterProxy();
        $test = $this->mock('PHPUnit_Framework_Test')->done();
        $e = $this->mock('Exception')->done();
        $proxy->addIncompleteTest($test, $e, 0);
        $this->assert($proxy->getResultPrinter()->getIncompleteCount(), equals, 1);
    }

    public function testAddSkippedWillIncrementCount()
    {
        $proxy = new ResultPrinterProxy();
        $test = $this->mock('PHPUnit_Framework_Test')->done();
        $e = $this->mock('Exception')->done();
        $proxy->addSkippedTest($test, $e, 0);
        $this->assert($proxy->getResultPrinter()->getSkippedCount(), equals, 1);
    }

    public function testAddRiskyWillIncrementCount()
    {
        $proxy = new ResultPrinterProxy();
        $test = $this->mock('PHPUnit_Framework_Test')->done();
        $e = $this->mock('Exception')->done();
        $proxy->addRiskyTest($test, $e, 0);
        $this->assert($proxy->getResultPrinter()->getRiskyCount(), equals, 1);
    }

    public function testAddFailureWillCallResultPrinter()
    {
        $test = $this->mock('PHPUnit_Framework_Test')->done();
        $e = $this->mock('PHPUnit_Framework_AssertionFailedError')->done();

        $resultPrinter = $this->mock('Concise\Console\ResultPrinterInterface')
                              ->expect('addFailure')->with($test, $e, 0.1)
                              ->done();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->addFailure($test, $e, 0.1);
    }

    public function testAddErrorWillCallResultPrinter()
    {
        $test = $this->mock('PHPUnit_Framework_Test')->done();
        $e = $this->mock('Exception')->done();

        $resultPrinter = $this->mock('Concise\Console\ResultPrinterInterface')
                              ->expect('addError')->with($test, $e, 0.1)
                              ->done();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->addError($test, $e, 0.1);
    }

    public function testAddIncompleteWillCallResultPrinter()
    {
        $test = $this->mock('PHPUnit_Framework_Test')->done();
        $e = $this->mock('Exception')->done();

        $resultPrinter = $this->mock('Concise\Console\ResultPrinterInterface')
                              ->expect('addIncompleteTest')->with($test, $e, 0.1)
                              ->done();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->addIncompleteTest($test, $e, 0.1);
    }

    public function testAddSkippedWillCallResultPrinter()
    {
        $test = $this->mock('PHPUnit_Framework_Test')->done();
        $e = $this->mock('Exception')->done();

        $resultPrinter = $this->mock('Concise\Console\ResultPrinterInterface')
                              ->expect('addSkippedTest')->with($test, $e, 0.1)
                              ->done();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->addSkippedTest($test, $e, 0.1);
    }

    public function testAddRiskyWillCallResultPrinter()
    {
        $test = $this->mock('PHPUnit_Framework_Test')->done();
        $e = $this->mock('Exception')->done();

        $resultPrinter = $this->mock('Concise\Console\ResultPrinterInterface')
                              ->expect('addRiskyTest')->with($test, $e, 0.1)
                              ->done();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->addRiskyTest($test, $e, 0.1);
    }

    public function testEndTestWillCallResultPrinter()
    {
        $test = $this->mock('PHPUnit_Framework_Test')->done();

        $resultPrinter = $this->mock('Concise\Console\ResultPrinterInterface')
                              ->expect('endTest')->with($test, 0.1)
                              ->done();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->endTest($test, 0.1);
    }

    public function testEndTestWillIncrementTestCount()
    {
        $test = $this->mock('PHPUnit_Framework_Test')->done();

        $proxy = new ResultPrinterProxy();
        $proxy->endTest($test, 0.1);
        $this->assert($proxy->getResultPrinter()->getTestCount(), equals, 1);
    }

    public function testStartTestSuiteWillCallResultPrinter()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')->disableConstructor()->done();

        $resultPrinter = $this->mock('Concise\Console\ResultPrinterInterface')
                              ->expect('startTestSuite')->with($suite)
                              ->done();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->startTestSuite($suite);
    }
}
