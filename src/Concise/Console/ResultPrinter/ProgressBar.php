<?php

namespace Concise\Console\ResultPrinter;

use Colors\Color;

class ProgressBar
{
    public function render($size, array $parts)
    {
        $c = new Color();
        $r = '';

        foreach ($parts as $color => $x) {
            $r .= $c(str_repeat(' ', $x))->highlight($color);
        }

        return $r;
    }
}
