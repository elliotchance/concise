<?php

namespace Concise\Console;

use Concise\Core\TestCase;

/**
 * @group 275
 */
class TerminalTest extends TestCase
{
    public function testGetColumnsIsAnInteger()
    {
        $terminal = new Terminal();
        $this->assert($terminal->getColumns())->isAnInteger;
    }

    public function testGetColumnsFromTheActiveTerminal()
    {
        $terminal = new Terminal();
        $this->assert($terminal->getColumns())->equals(`tput cols`);
    }

    public function testGetColumnsIs80ForUnknownTerminal()
    {
        $term = getenv('TERM');
        putenv('TERM=');
        $terminal = new Terminal();
        $this->assert($terminal->getColumns())->equals(80);
        putenv("TERM=$term");
    }

    public function testGetColorsIsAnInteger()
    {
        $terminal = new Terminal();
        $this->assert($terminal->getColors())->isAnInteger;
    }

    public function testGetColorsFromTheActiveTerminal()
    {
        $terminal = new Terminal();
        $this->assert($terminal->getColors())->equals(`tput colors`);
    }

    public function testGetColorsIs1ForUnknownTerminal()
    {
        $term = getenv('TERM');
        putenv('TERM=');
        $terminal = new Terminal();
        $this->assert($terminal->getColors())->equals(1);
        putenv("TERM=$term");
    }
}
