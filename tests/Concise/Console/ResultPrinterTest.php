<?php

namespace Concise\Console;

use \Concise\TestCase;

class ResultPrinterTest extends TestCase
{
    public function testResultPrinterImplementsResultPrinterInterface()
    {
        $this->assert(new ResultPrinter(), instance_of, 'Concise\Console\ResultPrinterInterface');
    }

    public function testResultPrinterExtendsAbstractResultPrinter()
    {
        $this->assert(new ResultPrinter(), instance_of, 'Concise\Console\AbstractResultPrinter');
    }

    public function testDefaultSuccessesIsZero()
    {
        $resultPrinter = new ResultPrinter();
        $this->assert($resultPrinter->getSuccessCount(), exactly_equals, 0);
    }
}
