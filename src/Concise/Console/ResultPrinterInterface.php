<?php

namespace Concise\Console;

use Exception;
use PHPUnit_Framework_AssertionFailedError;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestSuite;

interface ResultPrinterInterface
{
    public function getSuccessCount();

    public function getFailureCount();

    public function getErrorCount();

    public function getIncompleteCount();

    public function getRiskyCount();

    public function getSkippedCount();

    public function getTestCount();

    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time);

    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time);

    public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time);

    public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time);

    public function addRiskyTest(PHPUnit_Framework_Test $test, Exception $e, $time);

    public function endTest(PHPUnit_Framework_Test $test, $time);

    public function startTestSuite(PHPUnit_Framework_TestSuite $suite);
}
