<?php

namespace Concise\Console;

abstract class AbstractResultPrinter implements ResultPrinterInterface
{
    public function getSuccessCount()
    {
        return 0;
    }
}
