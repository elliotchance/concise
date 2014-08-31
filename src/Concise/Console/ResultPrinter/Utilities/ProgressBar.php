<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Colors\Color;

class ProgressBar
{
    protected $total;

    protected $size;

    protected $parts;

    protected function valueToBars($value)
    {
        return ceil($value / $this->total * $this->size);
    }

    protected function calculateTotal(array $parts)
    {
        $this->total = array_sum($parts);
    }

    protected function colorSpaces($length, $colorName)
    {
        $c = new Color();

        return (string) $c(str_repeat(' ', $length))->highlight($colorName);
    }

    protected function fillToSize($currentProgressBar)
    {
        reset($this->parts);
        $fill = $this->size - substr_count($currentProgressBar, ' ');
        if ($fill > 0) {
            $currentProgressBar = $this->colorSpaces($fill, key($this->parts)) . (string) $currentProgressBar;
        } elseif ($fill < 0) {
            $currentProgressBar = preg_replace('/\s\s/', ' ', $currentProgressBar, -$fill);
        }

        return $currentProgressBar;
    }

    public function render($size, array $parts)
    {
        $this->calculateTotal($parts);
        $this->size = $size;
        $this->parts = $parts;

        $r = '';

        foreach ($parts as $color => $x) {
            $bars = $this->valueToBars($x);
            $r .= $this->colorSpaces($bars, $color);
        }

        $r = $this->fillToSize($r);

        return $r;
    }
}
