<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\Console\Theme\ThemeColor;
use Concise\Core\TestCase;

/**
 * @group #339
 */
class ColorTextTest extends TestCase
{
    public function testNoneWillNotAddAnyEscapeCodes()
    {
        $color = new ColorText();
        $this->assert($color->color('foo', ThemeColor::NONE, ThemeColor::NONE))
            ->exactlyEquals('foo');
    }

    public function testAValidColorWillAddOpenEscapeCode()
    {
        $color = new ColorText();
        $this->assertString($color->color('foo', ThemeColor::BLUE, ThemeColor::NONE))
            ->startsWith("\033[34m");
    }

    public function testAValidColorWillAddClearEscapeCode()
    {
        $color = new ColorText();
        $this->assertString($color->color('foo', ThemeColor::BLUE, ThemeColor::NONE))
            ->endsWith("\033[0m");
    }

    public function testGreen()
    {
        $color = new ColorText();
        $this->assertString($color->color('foo', ThemeColor::GREEN, ThemeColor::NONE))
            ->endsWith("\033[0m");
    }

    public function testAValidBackgroundColorWillAddOpenEscapeCode()
    {
        $color = new ColorText();
        $this->assertString(
            $color->color('foo', ThemeColor::BLUE, ThemeColor::RED)
        )
            ->startsWith("\033[41m\033[34m");
    }
}
