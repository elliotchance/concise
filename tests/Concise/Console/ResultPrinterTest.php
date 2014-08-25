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

    public function testDefaultSuccessCountIsZero()
    {
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 0);
    }

    public function testDefaultFailureCountIsZero()
    {
        $this->assert($this->resultPrinter->getFailureCount(), exactly_equals, 0);
    }

    public function testDefaultErrorCountIsZero()
    {
        $this->assert($this->resultPrinter->getErrorCount(), exactly_equals, 0);
    }

    public function testDefaultIncompleteCountIsZero()
    {
        $this->assert($this->resultPrinter->getIncompleteCount(), exactly_equals, 0);
    }

    public function testDefaultRiskyCountIsZero()
    {
        $this->assert($this->resultPrinter->getRiskyCount(), exactly_equals, 0);
    }
}
