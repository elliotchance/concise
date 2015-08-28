<?php

namespace Concise\Console;

use Concise\TestCase;

class CommandColorSchemeTest extends TestCase
{
    /**
     * @var Command
     */
    protected $command;

    public function setUp()
    {
        parent::setUp();
        $this->command = new Command();
    }

    public function testDefaultColorSchemeIsSet()
    {
        $this->aassert($this->command->getColorScheme())
            ->instanceOf('Concise\Console\Theme\DefaultTheme');
    }

    public function testColorSchemeCanBeAClassName()
    {
        $theme = $this->mock('Concise\Console\Theme\DefaultTheme')->get();
        $this->setProperty($this->command, 'colorScheme', get_class($theme));
        $this->aassert(get_class($this->command->getColorScheme()))
            ->equals(get_class($theme));
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
        $this->aassert($this->command->getColorScheme())
            ->instanceOf('Concise\Console\Theme\DefaultTheme');
    }

    public function testColorSchemeWithLowerCase()
    {
        $this->setProperty($this->command, 'colorScheme', 'default');
        $this->aassert($this->command->getColorScheme())
            ->instanceOf('Concise\Console\Theme\DefaultTheme');
    }
}
