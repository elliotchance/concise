<?php

namespace Concise\Console\ResultPrinter\Utilities;

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
        return $text;
    }
}