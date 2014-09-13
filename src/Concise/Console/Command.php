<?php

namespace Concise\Console;

use Concise\Console\TestRunner\DefaultTestRunner;
use Concise\Console\ResultPrinter\ResultPrinterProxy;
use Concise\Console\ResultPrinter\DefaultResultPrinter;

class Command extends \PHPUnit_TextUI_Command
{
    protected function createRunner()
    {
        $resultPrinter = new DefaultResultPrinter();
        $testRunner = new DefaultTestRunner();
        $testRunner->setPrinter(new ResultPrinterProxy($resultPrinter));

        return $testRunner;
    }
}
