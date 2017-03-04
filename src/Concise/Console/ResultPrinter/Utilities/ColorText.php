<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Colors\Color;
use Concise\Console\Theme\ThemeColor;

/**
 * Will return a peice of text with ANSI escape codes for colors.
 *
 * The constants are defined in `ThemeColor`. `NONE` is a special color that
 * will not add any escape codes to the text.
 */
class ColorText
{
    public function color($text, $color, $backgroudColor)
    {
        if ($color === ThemeColor::NONE) {
            return $text;
        }

        $c = new Color();
        $t = $c($text)->$color;

        if ($backgroudColor !== ThemeColor::NONE) {
            $t->highlight($backgroudColor);
        }

        return (string)$t;
    }
}