<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\Console\Theme\ThemeColor;
use Concise\Core\TestCase;

class ProgressBarTestCase extends TestCase
{
    protected function color($size, $color)
    {
        $c = new ColorText();

        return $c->color(str_repeat(' ', $size), ThemeColor::NONE, $color);
    }
}
