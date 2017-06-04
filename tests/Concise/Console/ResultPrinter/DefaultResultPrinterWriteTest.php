<?php

namespace Concise\Console\ResultPrinter;

use Concise\Console\Theme\DefaultTheme;
use Concise\Core\TestCase;

class DefaultResultPrinterWriteStub extends DefaultResultPrinter
{
}

class DefaultResultPrinterWriteTest extends TestCase
{
    public function testWritingWillEchoDirectly()
    {
        $resultPrinter = new DefaultResultPrinterWriteStub(new DefaultTheme());
        $this->expectOutputString('foobar');
        $resultPrinter->write('foobar');
    }
}
