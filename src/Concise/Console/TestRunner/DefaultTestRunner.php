<?php

namespace Concise\Console\TestRunner;

use Concise\Extensions\Pho\PhoTestSuite;
use File_Iterator_Facade;
use PHPUnit_TextUI_TestRunner;

class DefaultTestRunner extends PHPUnit_TextUI_TestRunner
{
    public function getPrinter()
    {
        return $this->printer;
    }

    public function getTest($suiteClassName, $suiteClassFile = '', $suffixes = '')
    {
        if (is_dir($suiteClassName) &&
            !is_file($suiteClassName . '.php') && empty($suiteClassFile)) {
            $facade = new File_Iterator_Facade;
            $files  = $facade->getFilesAsArray(
                $suiteClassName,
                $suffixes
            );

            $suite = new PhoTestSuite($suiteClassName);
            $suite->addTestFiles($files);

            return $suite;
        }

        return parent::getTest($suiteClassName, $suiteClassFile, $suffixes);
    }
}
