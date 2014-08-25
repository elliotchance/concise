<?php

namespace Concise\Console;

abstract class AbstractResultPrinter implements ResultPrinterInterface
{
    public $failureCount = 0;

    public function getSuccessCount()
    {
        return 0;
    }

    public function getFailureCount()
    {
        return $this->failureCount;
    }

    public function getErrorCount()
    {
        return 0;
    }

    public function getIncompleteCount()
    {
        return 0;
    }

    public function getRiskyCount()
    {
        return 0;
    }

    public function getSkippedCount()
    {
        return 0;
    }
}
