<?php

namespace Concise\Console;

use Concise\Core\TestCase;

class CommandStub extends Command
{
    public function setArgument($name, $value)
    {
        $this->arguments[$name] = $value;
    }

    public function setCI($ci)
    {
        $this->ci = $ci;
    }
}

class CommandTest extends TestCase
{
    public function testCommandExtendsPHPUnit()
    {
        $this->assert(new Command())->isAnInstanceOf('PHPUnit_TextUI_Command');
    }

    protected function getCommandMock()
    {
        return $this->niceMock('Concise\Console\CommandStub')
            ->expose('createRunner')->get();
    }

    public function testCreateRunnerReturnsAConciseRunner()
    {
        $command = $this->getCommandMock();
        $this->assert($command->createRunner())
            ->isAnInstanceOf('Concise\Console\TestRunner\DefaultTestRunner');
    }

    public function testPrinterUsesProxy()
    {
        $command = $this->getCommandMock();
        $this->assert($command->createRunner()->getPrinter())
            ->isAnInstanceOf('Concise\Console\ResultPrinter\ResultPrinterProxy');
    }

    public function testVerboseIsFalseByDefault()
    {
        $command = $this->getCommandMock();
        $this->assert(
            $command->createRunner()
                ->getPrinter()
                ->getResultPrinter()
                ->isVerbose()
        )->isFalse;
    }

    public function testVerboseIsTurnedOnIfItExistsAndHasBeenSet()
    {
        $command = $this->getCommandMock();
        $command->setArgument('verbose', true);
        $this->assert(
            $command->createRunner()
                ->getPrinter()
                ->getResultPrinter()
                ->isVerbose()
        )->isTrue;
    }

    public function testVerboseIsNotTurnedOnIfItExistsButIfNotTrue()
    {
        $command = $this->getCommandMock();
        $command->setArgument('verbose', false);
        $this->assert(
            $command->createRunner()
                ->getPrinter()
                ->getResultPrinter()
                ->isVerbose()
        )->isFalse;
    }

    public function testCIResultPrinterIsUsedIfCIIsTrue()
    {
        $command = $this->getCommandMock();
        $command->setCI(true);

        $this->assert($command->getResultPrinter())
            ->isAnInstanceOf('Concise\Console\ResultPrinter\CIResultPrinter');
    }

    public function testDefaultResultPrinterIsNotUsedIfCIIsFalse()
    {
        $command = $this->getCommandMock();
        $command->setCI(false);

        $this->assert($command->getResultPrinter())
            ->isAnInstanceOf('Concise\Console\ResultPrinter\DefaultResultPrinter');
    }

    public function testDefaultResultPrinterIsUsedByDefault()
    {
        $command = $this->getCommandMock();
        $this->assert($command->getResultPrinter())
            ->isAnInstanceOf('Concise\Console\ResultPrinter\DefaultResultPrinter');
    }
}
