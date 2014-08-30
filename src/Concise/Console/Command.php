<?php

namespace Concise\Console;

use Concise\Console\TestRunner\DefaultTestRunner;
use Concise\Console\ResultPrinter\ResultPrinterProxy;

class Command extends \PHPUnit_TextUI_Command
{
    protected function createRunner()
    {
        $testRunner = new DefaultTestRunner();
        $testRunner->setPrinter(new ResultPrinterProxy());

        return $testRunner;
    }
}
