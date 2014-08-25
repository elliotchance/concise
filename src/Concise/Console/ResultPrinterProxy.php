<?php

namespace Concise\Console;

use Exception;
use PHPUnit_Framework_AssertionFailedError;
use PHPUnit_Framework_Test;

class ResultPrinterProxy extends \PHPUnit_TextUI_ResultPrinter
{
    protected $resultPrinter;

    public function __construct(ResultPrinterInterface $resultPrinter = null)
    {
        parent::__construct();
        if ($resultPrinter) {
            $this->resultPrinter = $resultPrinter;
        } else {
            $this->resultPrinter = new ResultPrinter();
        }
    }

    public function getResultPrinter()
    {
        return $this->resultPrinter;
    }

    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
    {
        ++$this->getResultPrinter()->failureCount;
        $this->getResultPrinter()->addFailure($test, $e, $time);
    }

    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        ++$this->getResultPrinter()->errorCount;
        $this->getResultPrinter()->addError($test, $e, $time);
    }

    public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        ++$this->getResultPrinter()->incompleteCount;
        $this->getResultPrinter()->addIncompleteTest($test, $e, $time);
    }

    public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        ++$this->getResultPrinter()->skippedCount;
        $this->getResultPrinter()->addSkippedTest($test, $e, $time);
    }

    public function addRiskyTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        ++$this->getResultPrinter()->riskyCount;
        $this->getResultPrinter()->addRiskyTest($test, $e, $time);
    }

    protected function printHeader()
    {
    }

    protected function printDefects(array $defects, $type)
    {
    }

    protected function printDefect(PHPUnit_Framework_TestFailure $defect, $count)
    {
    }

    public function endTest(PHPUnit_Framework_Test $test, $time)
    {
        $this->getResultPrinter()->endTest($test, $time);
    }
}
