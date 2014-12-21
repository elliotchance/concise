<?php

namespace Concise\Console;

use Concise\Console\TestRunner\DefaultTestRunner;
use Concise\Console\ResultPrinter\ResultPrinterProxy;
use Concise\Console\ResultPrinter\DefaultResultPrinter;
use Concise\Console\Theme\DefaultTheme;
use Exception;
use Concise\Console\ResultPrinter\CIResultPrinter;

class Command extends \PHPUnit_TextUI_Command
{
    /**
     * @var string
     */
    protected $colorScheme = '';

    /**
     * @var bool
     */
    protected $ci = false;

    protected function createRunner()
    {
        $resultPrinter = $this->getResultPrinter();
        if (array_key_exists('verbose', $this->arguments) && $this->arguments['verbose']) {
            $resultPrinter->setVerbose(true);
        }
        $testRunner = new DefaultTestRunner();
        $testRunner->setPrinter(new ResultPrinterProxy($resultPrinter));

        return $testRunner;
    }

    /**
     * @param string $class
     * @return null|object
     */
    protected function getThemeForClass($class)
    {
        if (class_exists($class)) {
            return new $class();
        }

        return null;
    }

    /**
     * @throws Exception
     * @return string
     */
    protected function findTheme()
    {
        $candidates = array($this->colorScheme, "Concise\\Console\\Theme\\{$this->colorScheme}Theme");
        foreach ($candidates as $class) {
            $r = $this->getThemeForClass($class);
            if ($r) {
                return $r;
            }
        }

        throw new Exception("No such color scheme '{$this->colorScheme}'.");
    }

    public function getColorScheme()
    {
        if ($this->colorScheme) {
            return $this->findTheme();
        }

        return new DefaultTheme();
    }

    public function getResultPrinter()
    {
        if ($this->ci || `tput colors` < 2) {
            return new CIResultPrinter();
        }

        return new DefaultResultPrinter();
    }

    /**
     * @codeCoverageIgnore
     * @param array $argv
     */
    protected function handleArguments(array $argv)
    {
        $this->longOptions['test-colors'] = null;
        $this->longOptions['color-scheme='] = null;
        $this->longOptions['list-color-schemes'] = null;
        $this->longOptions['ci'] = null;
        parent::handleArguments($argv);

        foreach ($this->options[0] as $option) {
            switch ($option[0]) {
                case '--test-colors':
                    $testColors = new TestColors();
                    echo $testColors->renderAll();
                    exit(0);

                case '--color-scheme':
                    $this->colorScheme = $option[1];
                    break;

                case '--list-color-schemes':
                    echo "Color Schemes:\n  default\n\n";
                    exit(0);

                case '--ci':
                    $this->ci = true;
                    break;
            }
        }
    }
}
