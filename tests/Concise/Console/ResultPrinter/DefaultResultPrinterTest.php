<?php

namespace Concise\Console\ResultPrinter;

use Concise\TestCase;
use PHPUnit_Runner_BaseTestRunner;

class DefaultResultPrinterStub extends DefaultResultPrinter
{
    public function getWidth()
    {
        return $this->width;
    }

    public function getIssueNumber()
    {
        return $this->issueNumber;
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

    public function testFirstIssueNumberIsOne()
    {
        $this->assert($this->resultPrinter->getIssueNumber(), equals, 1);
    }

    public function testEndTestWillIncrementIssueNumber()
    {
        $test = $this->mock('PHPUnit_Framework_Test')->done();
        $this->resultPrinter->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, $test, 0, null);
        $this->assert($this->resultPrinter->getIssueNumber(), equals, 2);
    }
}
