<?php

namespace Concise\Console;

abstract class AbstractResultPrinter implements ResultPrinterInterface
{
    public $failureCount = 0;

    public $errorCount = 0;

    public $incompleteCount = 0;

    public $skippedCount = 0;

    public $riskyCount = 0;

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
        return $this->errorCount;
    }

    public function getIncompleteCount()
    {
        return $this->incompleteCount;
    }

    public function getRiskyCount()
    {
        return $this->riskyCount;
    }

    public function getSkippedCount()
    {
        return $this->skippedCount;
    }
}
