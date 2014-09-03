<?php

namespace Concise\Console\TestRunner;

class DefaultTestRunner extends \PHPUnit_TextUI_TestRunner
{
    public function getPrinter()
    {
        return $this->printer;
    }
}
