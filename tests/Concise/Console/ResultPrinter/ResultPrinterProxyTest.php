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
                    ->done();
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
        $test = $this->mock('PHPUnit_Framework_Test')->done();
        $this->proxy->endTest($test, 0.1);
        $this->assert($this->proxy->getResultPrinter()->getTestCount(), equals, 1);
    }
}
