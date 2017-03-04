<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\Console\Theme\ThemeColor;

/**
 * Will return a peice of text with ANSI escape codes for colours. The constants
 * are defined in `ThemeColor`.
 *
 * `NONE` is a special color that will not add any escape codes to the text.
 */
class ColorText
{
    public function color($text, $color)
    {
        if ($color === ThemeColor::BLUE) {
            return '\033[39;40m' . $text . '\033[0m';
        }
        return $text;
    }
}