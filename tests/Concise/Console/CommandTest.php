<?php

namespace Concise\Console;

use \Concise\TestCase;

class CommandTest extends TestCase
{
    public function testCommandExtendsPHPUnit()
    {
        $this->assert(new Command(), instance_of, 'PHPUnit_TextUI_Command');
    }

    protected function getCommandMock()
    {
        return $this->niceMock('Concise\Console\Command')
                    ->expose('createRunner')
                    ->done();
    }

    public function testCreateRunnerReturnsAConciseRunner()
    {
        $command = $this->getCommandMock();
        $this->assert($command->createRunner(), instance_of, 'Concise\Console\TestRunner\DefaultTestRunner');
    }

    public function testPrinterUsesProxy()
    {
        $command = $this->getCommandMock();
        $this->assert($command->createRunner()->getPrinter(), instance_of, 'Concise\Console\ResultPrinter\ResultPrinterProxy');
    }

    public function testVerboseIsFalseByDefault()
    {
        $command = $this->getCommandMock();
        $this->assert($command->createRunner()->getPrinter()->getResultPrinter()->isVerbose(), is_false);
    }
}
