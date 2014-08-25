<?php

namespace Concise\Console;

use \PHPUnit_Framework_AssertionFailedError;
use \PHPUnit_Framework_Test;

interface ResultPrinterInterface
{
    public function getSuccessCount();

    public function getFailureCount();

    public function getErrorCount();

    public function getIncompleteCount();

    public function getRiskyCount();

    public function getSkippedCount();

    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time);
}
