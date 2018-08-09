<?php

namespace Concise\Console\TestRunner;

use PHPUnit\TextUI\TestRunner;

class DefaultTestRunner extends TestRunner
{
    public function getPrinter()
    {
        return $this->printer;
    }
}
