<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\Console\Theme\ThemeColor;

/**
 * Will return a peice of text with ANSI escape codes for colors.
 *
 * The constants are defined in `ThemeColor`. `NONE` is a special color that
 * will not add any escape codes to the text.
 */
class ColorText
{
    public function color($text, $textColor, $backgroudColor = ThemeColor::NONE)
    {
        if ($textColor !== ThemeColor::NONE &&
            $backgroudColor !== ThemeColor::NONE
        ) {
            return "\e[3$textColor;4{$backgroudColor}m$text\e[0m";
        }

        if ($textColor !== ThemeColor::NONE) {
            return "\e[3{$textColor}m$text\e[0m";
        }

        if ($backgroudColor !== ThemeColor::NONE) {
            return "\e[4{$backgroudColor}m$text\e[0m";
        }

        return $text;
    }

    /**
     * Remove the ANSI escape codes from a string.
     * @param string $colored
     */
    public function clean($colored)
    {
        return preg_replace("/\e\\[[\\d;]+m/", '', $colored);
    }
}
