<?php

namespace Concise\Console\ResultPrinter;

use Concise\TestCase;

class DefaultResultPrinterWriteStub extends DefaultResultPrinter
{
}

class DefaultResultPrinterWriteTest extends TestCase
{
    public function testWritingWillEchoDirectly()
    {
        $resultPrinter = new DefaultResultPrinterWriteStub();
        $this->expectOutputString('foobar');
        $resultPrinter->write('foobar');
    }

    public function testWillPrintThreeBlankLinesAtTheEndOfTheTestSuite()
    {
        $this->expectOutputString("\n\n\n");
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                              ->stub('update')
                              ->get();
        $resultPrinter->end();
    }
}
