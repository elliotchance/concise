<?php

namespace Concise\Console;

class Command extends \PHPUnit_TextUI_Command
{
    protected function createRunner()
    {
        $testRunner = new TestRunner();
        $testRunner->setPrinter(new ResultPrinterProxy());

        return $testRunner;
    }
}
