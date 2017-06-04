<?php

namespace Concise\Extensions\Pho;

use Concise\Console\TestRunner\DefaultTestRunner;
use File_Iterator_Facade;

class PhoTestRunner extends DefaultTestRunner
{
    public function getTest(
        $suiteClassName,
        $suiteClassFile = '',
        $suffixes = ''
    ) {
        if (is_dir($suiteClassName) &&
            !is_file($suiteClassName . '.php') && empty($suiteClassFile)
        ) {
            $facade = new File_Iterator_Facade;
            $files = $facade->getFilesAsArray(
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
