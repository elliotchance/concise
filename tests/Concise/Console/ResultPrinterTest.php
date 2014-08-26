<?php

namespace Concise\Console;

use \Concise\TestCase;

class ResultPrinterTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->resultPrinter = new ResultPrinter();
    }

    public function testWritingWillEchoDirectly()
    {
        $this->expectOutputString('foobar');
        $this->resultPrinter->write('foobar');
    }

    public function testWillPrintThreeBlankLinesAtTheEndOfTheTestSuite()
    {
        $this->expectOutputString("\n\n\n");
        $this->resultPrinter->finish();
    }
}
