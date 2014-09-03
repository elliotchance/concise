<?php

namespace Concise\Console\ResultPrinter;

use Concise\TestCase;

class DefaultResultPrinterWriteStub extends DefaultResultPrinter
{
}

class DefaultResultPrinterWriteTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->resultPrinter = new DefaultResultPrinterWriteStub();
    }

    public function testWritingWillEchoDirectly()
    {
        $this->expectOutputString('foobar');
        $this->resultPrinter->write('foobar');
    }

    public function testWillPrintThreeBlankLinesAtTheEndOfTheTestSuite()
    {
        $this->expectOutputString("\n\n\n");
        $this->resultPrinter->end();
    }
}
