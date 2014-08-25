<?php

namespace Concise\Console;

abstract class AbstractResultPrinter implements ResultPrinterInterface
{
    public $failureCount = 0;

    public $errorCount = 0;

    public $incompleteCount = 0;

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
        return 0;
    }

    public function getSkippedCount()
    {
        return 0;
    }
}
