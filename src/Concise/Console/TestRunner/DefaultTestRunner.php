<?php

namespace Concise\Console\TestRunner;

use PHPUnit_TextUI_TestRunner;

class DefaultTestRunner extends PHPUnit_TextUI_TestRunner
{
    public function getPrinter()
    {
        return $this->printer;
    }
}
