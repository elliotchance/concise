<?php

namespace Concise\Console;

use \Exception;
use \PHPUnit_Framework_AssertionFailedError;
use \PHPUnit_Framework_Test;

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
    }

    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        ++$this->getResultPrinter()->errorCount;
    }
}
