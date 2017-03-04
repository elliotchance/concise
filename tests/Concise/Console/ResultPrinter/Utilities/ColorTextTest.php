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
        $this->assert($color->color('foo', ThemeColor::NONE))
            ->exactlyEquals('foo');
    }
}
