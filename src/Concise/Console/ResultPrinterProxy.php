<?php

namespace Concise\Console;

class ResultPrinterProxy extends \PHPUnit_TextUI_ResultPrinter
{
    public function getResultPrinter()
    {
        return new ResultPrinter();
    }
}
