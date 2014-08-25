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
}
