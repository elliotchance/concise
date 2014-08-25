<?php

namespace Concise\Console;

use \Concise\TestCase;

class CommandTest extends TestCase
{
    public function testCommandExtendsPHPUnit()
    {
        $this->assert(new Command(), instance_of, 'PHPUnit_TextUI_Command');
    }

    public function testCreateRunnerReturnsAConciseRunner()
    {
        $command = $this->niceMock('Concise\Console\Command')
                        ->expose('createRunner')
                        ->done();
        $this->assert($command->createRunner(), instance_of, 'Concise\Console\TestRunner');
    }
}
