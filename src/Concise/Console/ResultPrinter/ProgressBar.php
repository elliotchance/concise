<?php

namespace Concise\Console\ResultPrinter;

use Colors\Color;

class ProgressBar
{
    protected $total;

    protected $size;

    protected function valueToBars($value)
    {
        return $value / $this->total * $this->size;
    }

    protected function calculateTotal(array $parts)
    {
        $this->total = array_sum($parts);
    }

    public function render($size, array $parts)
    {
        $this->calculateTotal($parts);
        $this->size = $size;

        $c = new Color();
        $r = '';

        foreach ($parts as $color => $x) {
            $bars = $this->valueToBars($x);
            $r .= $c(str_repeat(' ', $bars))->highlight($color);
        }

        return $r;
    }
}
