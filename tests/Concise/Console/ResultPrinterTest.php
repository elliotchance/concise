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

    public function testResultPrinterImplementsResultPrinterInterface()
    {
        $this->assert($this->resultPrinter, instance_of, 'Concise\Console\ResultPrinterInterface');
    }

    public function testResultPrinterExtendsAbstractResultPrinter()
    {
        $this->assert($this->resultPrinter, instance_of, 'Concise\Console\AbstractResultPrinter');
    }

    public function testDefaultSuccessesIsZero()
    {
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 0);
    }

    public function testDefaultFailuresIsZero()
    {
        $this->assert($this->resultPrinter->getFailureCount(), exactly_equals, 0);
    }
}
