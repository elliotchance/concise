<?php

namespace Concise\Console;

use Concise\Console\TestRunner\DefaultTestRunner;
use Concise\Console\ResultPrinter\ResultPrinterProxy;
use Concise\Console\ResultPrinter\DefaultResultPrinter;
use Concise\Console\Theme\DefaultTheme;
use Exception;

class Command extends \PHPUnit_TextUI_Command
{
    protected $colorScheme = null;

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

    public function getColorScheme()
    {
        if ($this->colorScheme) {
            if (class_exists($this->colorScheme)) {
                return new $this->colorScheme();
            }
            throw new Exception("No such color scheme '{$this->colorScheme}'.");
        }

        return new DefaultTheme();
    }

    /**
     * @codeCoverageIgnore
     */
    protected function handleArguments(array $argv)
    {
        $this->longOptions['test-colors'] = null;
        $this->longOptions['color-scheme='] = null;
        parent::handleArguments($argv);

        foreach ($this->options[0] as $option) {
            switch ($option[0]) {
                case '--test-theme':
                    $testColors = new TestColors(new DefaultTheme());
                    echo $testColors->renderAll();
                    exit(0);
                    break;

                case '--color-scheme':
                    $this->colorTheme = $option[1];
                    break;
            }
        }
    }
}
