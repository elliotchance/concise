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
        $prefix = '';
        if ($textColor !== ThemeColor::NONE &&
            $backgroudColor !== ThemeColor::NONE
        ) {
            $prefix = "\e[3$textColor;4{$backgroudColor}m";
        } elseif ($textColor !== ThemeColor::NONE) {
            $prefix = "\e[3{$textColor}m";
        } elseif ($backgroudColor !== ThemeColor::NONE) {
            $prefix = "\e[4{$backgroudColor}m";
        }

        $suffix = '';
        if ($prefix) {
            $suffix = "\e[0m";
        }

        // A new line in most terminals will clear out some or all of the escape
        // codes. We need to apply the formatting to each line.
        $lines = explode("\n", $text);

        return implode(
            "\n",
            array_map(
                function ($line) use ($prefix, $suffix) {
                    return "$prefix$line$suffix";
                },
                $lines
            )
        );
    }

    /**
     * Remove the ANSI escape codes from a string.
     *
     * @param string $colored
     */
    public function clean($colored)
    {
        return preg_replace("/\e\\[[\\d;]+m/", '', $colored);
    }
}
