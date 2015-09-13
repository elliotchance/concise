<?php

namespace Concise\Console\ResultPrinter;

use Concise\Core\TestCase;

class ResultPrinterProxyTest extends TestCase
{
    /**
     * @var ResultPrinterProxy
     */
    protected $proxy;

    public function setUp()
    {
        parent::setUp();
        $this->proxy = new ResultPrinterProxy($this->getMuteResultPrinter());
    }

    protected function getMuteResultPrinter()
    {
        return $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->stub('write')->get();
    }

    public function testProxyExtendsPHPUnit()
    {
        $this->assert($this->proxy)->instanceOf('PHPUnit_TextUI_ResultPrinter');
    }

    public function testGetResultPrinterReturnsAResultPrinterInterface()
    {
        $this->assert($this->proxy->getResultPrinter())
            ->instanceOf('Concise\Console\TestRunner\TestResultDelegateInterface');
    }

    public function testResultPrinterIsSetViaConstructor()
    {
        $printer = new DefaultResultPrinter();
        $proxy = new ResultPrinterProxy($printer);
        $this->assert($proxy->getResultPrinter())->isTheSameAs($printer);
    }

    public function testEndTestWillIncrementTestCount()
    {
        $test = $this->mock('PHPUnit_Framework_Test')->get();
        $this->proxy->endTest($test, 0.1);
        $this->assert($this->proxy->getResultPrinter()->getTestCount())
            ->equals(1);
    }

    public function testPrintHeaderReturnsNull()
    {
        $proxy = $this->niceMock(
            'Concise\Console\ResultPrinter\ResultPrinterProxy',
            array($this->getMuteResultPrinter())
        )->expose('printHeader')->get();
        $this->assert($proxy->printHeader())->isNull;
    }

    public function testPrintDefectsReturnsNull()
    {
        $proxy = $this->niceMock(
            'Concise\Console\ResultPrinter\ResultPrinterProxy',
            array($this->getMuteResultPrinter())
        )->expose('printDefects')->get();
        $this->assert($proxy->printDefects(array(), null))->isNull;
    }

    public function testPrintDefectReturnsNull()
    {
        $failure = $this->mock('PHPUnit_Framework_TestFailure')
            ->disableConstructor()
            ->get();
        $proxy = $this->niceMock(
            'Concise\Console\ResultPrinter\ResultPrinterProxy',
            array($this->getMuteResultPrinter())
        )->expose('printDefect')->get();
        $this->assert($proxy->printDefect($failure, 0))->isNull;
    }

    public function testPrintFooterReturnsNull()
    {
        $result = $this->mock('PHPUnit_Framework_TestResult')->get();
        $proxy = $this->niceMock(
            'Concise\Console\ResultPrinter\ResultPrinterProxy',
            array($this->getMuteResultPrinter())
        )->expose('printFooter')->get();
        $this->assert($proxy->printFooter($result))->isNull;
    }

    public function testWriteWillNotPrintAnything()
    {
        $this->assert($this->proxy->write('nothing'))->isNull;
    }

    public function testPrintResultReturnsNull()
    {
        $result = $this->mock('PHPUnit_Framework_TestResult')->get();
        $proxy = $this->niceMock(
            'Concise\Console\ResultPrinter\ResultPrinterProxy',
            array($this->getMuteResultPrinter())
        )->expose('printResult')->get();
        $this->assert($proxy->printResult($result))->isNull;
    }
}
