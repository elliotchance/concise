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
}
