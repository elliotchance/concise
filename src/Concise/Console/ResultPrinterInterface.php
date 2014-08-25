<?php

namespace Concise\Console;

interface ResultPrinterInterface
{
    public function getSuccessCount();

    public function getFailureCount();
}
