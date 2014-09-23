<?php

namespace Concise\Console;

use \Concise\TestCase;

class CommandStub extends Command
{
    public function setArgument($name, $value)
    {
        $this->arguments[$name] = $value;
    }
}

class CommandTest extends TestCase
{
    public function testCommandExtendsPHPUnit()
    {
        $this->assert(new Command(), instance_of, 'PHPUnit_TextUI_Command');
    }

    protected function getCommandMock()
    {
        return $this->niceMock('Concise\Console\CommandStub')
                    ->expose('createRunner')
                    ->get();
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

    public function testVerboseIsTurnedOnIfItExistsAndHasBeenSet()
    {
        $command = $this->getCommandMock();
        $command->setArgument('verbose', true);
        $this->assert($command->createRunner()->getPrinter()->getResultPrinter()->isVerbose(), is_true);
    }

    public function testVerboseIsNotTurnedOnIfItExistsButIfNotTrue()
    {
        $command = $this->getCommandMock();
        $command->setArgument('verbose', false);
        $this->assert($command->createRunner()->getPrinter()->getResultPrinter()->isVerbose(), is_false);
    }

    public function testDefaultColorSchemeIsSet()
    {
        $command = new Command();
        $this->assert($command->getColorScheme(), instance_of, 'Concise\Console\Theme\DefaultTheme');
    }

    public function testColorSchemeCanBeAClassName()
    {
        $command = new Command();
        $theme = $this->mock('Concise\Console\Theme\DefaultTheme')->get();
        $this->setProperty($command, 'colorScheme', get_class($theme));
        $this->assert(get_class($command->getColorScheme()), equals, get_class($theme));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No such color scheme 'Foo\Bar'.
     */
    public function testColorSchemeWillThrowExceptionIfColorSchemeClassDoesNotExist()
    {
        $command = new Command();
        $this->setProperty($command, 'colorScheme', 'Foo\Bar');
        $command->getColorScheme();
    }
}
