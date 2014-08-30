<?php

namespace Concise\Console\ResultPrinter;

use \Concise\TestCase;

class DefaultResultPrinterTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->resultPrinter = new DefaultResultPrinter();
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
