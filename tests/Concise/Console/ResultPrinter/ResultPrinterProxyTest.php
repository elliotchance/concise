<?php

namespace Concise\Console\ResultPrinter;

use Concise\TestCase;

class ResultPrinterProxyTest extends TestCase
{
    protected $proxy;

    public function setUp()
    {
        parent::setUp();
        $this->proxy = new ResultPrinterProxy($this->getMuteResultPrinter());
    }

    protected function getMuteResultPrinter()
    {
        return $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                    ->stub('write')
                    ->get();
    }

    public function testProxyExtendsPHPUnit()
    {
        $this->assert($this->proxy, instance_of, 'PHPUnit_TextUI_ResultPrinter');
    }

    public function testGetResultPrinterReturnsAResultPrinterInterface()
    {
        $this->assert($this->proxy->getResultPrinter(), instance_of, 'Concise\Console\TestRunner\TestResultDelegateInterface');
    }

    public function testResultPrinterIsSetViaConstructor()
    {
        $printer = new DefaultResultPrinter();
        $proxy = new ResultPrinterProxy($printer);
        $this->assert($proxy->getResultPrinter(), is_the_same_as, $printer);
    }

    public function testEndTestWillIncrementTestCount()
    {
        $test = $this->mock('PHPUnit_Framework_Test')->get();
        $this->proxy->endTest($test, 0.1);
        $this->assert($this->proxy->getResultPrinter()->getTestCount(), equals, 1);
    }

    public function testPrintHeaderReturnsNull()
    {
        $proxy = $this->niceMock('Concise\Console\ResultPrinter\ResultPrinterProxy', array($this->getMuteResultPrinter()))
                      ->expose('printHeader')
                      ->get();
        $this->assert($proxy->printHeader(), is_null);
    }

    public function testPrintDefectsReturnsNull()
    {
        $proxy = $this->niceMock('Concise\Console\ResultPrinter\ResultPrinterProxy', array($this->getMuteResultPrinter()))
                      ->expose('printDefects')
                      ->get();
        $this->assert($proxy->printDefects(array(), null), is_null);
    }

    public function testPrintDefectReturnsNull()
    {
        $failure = $this->mock('PHPUnit_Framework_TestFailure')->disableConstructor()->get();
        $proxy = $this->niceMock('Concise\Console\ResultPrinter\ResultPrinterProxy', array($this->getMuteResultPrinter()))
                      ->expose('printDefect')
                      ->get();
        $this->assert($proxy->printDefect($failure, 0), is_null);
    }

    public function testPrintFooterReturnsNull()
    {
        $result = $this->mock('PHPUnit_Framework_TestResult')->get();
        $proxy = $this->niceMock('Concise\Console\ResultPrinter\ResultPrinterProxy', array($this->getMuteResultPrinter()))
                      ->expose('printFooter')
                      ->get();
        $this->assert($proxy->printFooter($result), is_null);
    }

    public function testWriteWillNotPrintAnything()
    {
        $this->assert($this->proxy->write('nothing'), is_null);
    }

    public function testPrintResultReturnsNull()
    {
        $result = $this->mock('PHPUnit_Framework_TestResult')->get();
        $proxy = $this->niceMock('Concise\Console\ResultPrinter\ResultPrinterProxy', array($this->getMuteResultPrinter()))
                      ->expose('printResult')
                      ->get();
        $this->assert($proxy->printResult($result), is_null);
    }
}
