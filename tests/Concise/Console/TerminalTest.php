<?php

namespace Concise\Console;

use Concise\TestCase;

/**
 * @group 275
 */
class TerminalTest extends TestCase
{
    public function testGetColumnsIsAnInteger()
    {
        $terminal = new Terminal();
        $this->assert($terminal->getColumns(), is_an_integer);
    }

    public function testGetColumnsFromTheActiveTerminal()
    {
        $terminal = new Terminal();
        $this->assert($terminal->getColumns(), equals, `tput cols`);
    }
}
