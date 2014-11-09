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
}
