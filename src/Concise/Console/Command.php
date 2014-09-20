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
        if (array_key_exists('verbose', $this->arguments) && $this->arguments['verbose']) {
            $resultPrinter->setVerbose(true);
        }
        $testRunner = new DefaultTestRunner();
        $testRunner->setPrinter(new ResultPrinterProxy($resultPrinter));

        return $testRunner;
    }

    /**
     * @codeCoverageIgnore
     */
    protected function handleArguments(array $argv)
    {
        $this->longOptions['test-colors'] = null;
        parent::handleArguments($argv);

        foreach ($this->options[0] as $option) {
            switch ($option[0]) {
                case '--test-colors':
                    $testColors = new TestColors(new DefaultTheme());
                    echo $testColors->renderAll();
                    exit(0);
                    break;
            }
        }
    }
}
