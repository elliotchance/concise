<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\TestCase;
use Colors\Color;

class ProgressBarTestCase extends TestCase
{
    protected function color($size, $color)
    {
        $c = new Color();

        return (string) $c(str_repeat(' ', $size))->highlight($color);
    }
}
