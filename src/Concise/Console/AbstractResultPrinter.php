<?php

namespace Concise\Console;

abstract class AbstractResultPrinter implements ResultPrinterInterface
{
    public function getSuccessCount()
    {
        return 0;
    }

    public function getFailureCount()
    {
        return 0;
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
}
