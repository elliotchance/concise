<?php

namespace Concise\Console;

use Exception;
use PHPUnit_Framework_AssertionFailedError;
use PHPUnit_Framework_Test;

interface ResultPrinterInterface
{
    public function getSuccessCount();

    public function getFailureCount();

    public function getErrorCount();

    public function getIncompleteCount();

    public function getRiskyCount();

    public function getSkippedCount();

    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time);

    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time);
}
