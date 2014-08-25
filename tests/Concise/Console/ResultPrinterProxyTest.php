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
}
