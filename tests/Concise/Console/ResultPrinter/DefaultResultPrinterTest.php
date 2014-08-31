<?php

namespace Concise\Console\ResultPrinter;

use \Concise\TestCase;

class DefaultResultPrinterStub extends DefaultResultPrinter
{
    public function getWidth()
    {
        return $this->width;
    }
}

class DefaultResultPrinterTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->resultPrinter = new DefaultResultPrinterStub();
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

    public function testWillGetConsoleWidthOnStartup()
    {
        $this->assert($this->resultPrinter->getWidth(), equals, exec('tput cols'));
    }
}
