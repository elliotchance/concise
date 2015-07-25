<?php

namespace Concise\Console;

use Concise\TestCase;

class TerminalTest extends TestCase
{
    public function testGetColumns()
    {
        $terminal = new Terminal();
        $this->assert($terminal->getColumns(), is_an_integer);
    }
}
