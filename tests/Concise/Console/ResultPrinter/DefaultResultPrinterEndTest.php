<?php

namespace Concise\Console\ResultPrinter;

use Concise\TestCase;
use Concise\Console\Theme\DefaultTheme;
use Exception;
use PHPUnit_Runner_BaseTestRunner;

class DefaultResultPrinterEndTest extends TestCase
{
    public function testEndTestFailureWillCallAdd()
    {
        $e = new Exception();
        $test = $this->mock('PHPUnit_Framework_Test')->done();
        $theme = new DefaultTheme();
        $colors = $theme->getTheme();

        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                              ->expects('add')->with($test, $colors['failure'], $e)
                              ->done();
        $resultPrinter->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, $test, 1.23, $e);
    }
}
