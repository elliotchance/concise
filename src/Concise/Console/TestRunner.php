<?php

namespace Concise\Console;

class TestRunner extends \PHPUnit_TextUI_TestRunner
{
    public function getPrinter()
    {
        return $this->printer;
    }
}
