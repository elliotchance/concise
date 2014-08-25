<?php

namespace Concise\Console;

use \Concise\TestCase;

class CommandTest extends TestCase
{
    public function testCommandExtendsPHPUnit()
    {
        $this->assert(new Command(), instance_of, 'PHPUnit_TextUI_Command');
    }
}
