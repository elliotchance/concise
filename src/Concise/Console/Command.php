<?php

namespace Concise\Console;

class Command extends \PHPUnit_TextUI_Command
{
    protected function createRunner()
    {
        return new TestRunner();
    }
}
