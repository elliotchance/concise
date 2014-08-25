<?php

namespace Concise\Console;

class ResultPrinterProxy extends \PHPUnit_TextUI_ResultPrinter
{
    protected $resultPrinter;

    public function __construct(ResultPrinterInterface $resultPrinter = null)
    {
        parent::__construct();
        if ($resultPrinter) {
            $this->resultPrinter = $resultPrinter;
        } else {
            $this->resultPrinter = new ResultPrinter();
        }
    }

    public function getResultPrinter()
    {
        return $this->resultPrinter;
    }
}
