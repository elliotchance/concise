<?php

namespace Concise\Console;

use \Concise\TestCase;

class CommandColorSchemeTest extends TestCase
{
    protected $command;

    public function setUp()
    {
        parent::setUp();
        $this->command = new Command();
    }

    public function testDefaultColorSchemeIsSet()
    {
        $this->assert($this->command->getColorScheme(), instance_of, 'Concise\Console\Theme\DefaultTheme');
    }

    public function testColorSchemeCanBeAClassName()
    {
        $theme = $this->mock('Concise\Console\Theme\DefaultTheme')->get();
        $this->setProperty($this->command, 'colorScheme', get_class($theme));
        $this->assert(get_class($this->command->getColorScheme()), equals, get_class($theme));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No such color scheme 'Foo\Bar'.
     */
    public function testColorSchemeWillThrowExceptionIfColorSchemeClassDoesNotExist()
    {
        $this->setProperty($this->command, 'colorScheme', 'Foo\Bar');
        $this->command->getColorScheme();
    }

    public function testColorSchemeCanBeAClassNameFoundInTheDefaultNamespace()
    {
        $this->setProperty($this->command, 'colorScheme', 'Default');
        $this->assert($this->command->getColorScheme(), instance_of, 'Concise\Console\Theme\DefaultTheme');
    }
}
