<?php

namespace Concise\Console\ResultPrinter;

use Colors\Color;

class ProgressBar
{
    public function render($size, array $parts)
    {
        $c = new Color();

        return $c(str_repeat(' ', $size))->bg_green;
    }
}
