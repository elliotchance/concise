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
        return $value / $this->total * $this->size;
    }

    protected function calculateTotal(array $parts)
    {
        $this->total = array_sum($parts);
    }

    protected function fillToSize($currentProgressBar, Color $c)
    {
        reset($this->parts);
        $fill = $this->size - substr_count($currentProgressBar, ' ');
        if ($fill) {
            $currentProgressBar = (string) $c(str_repeat(' ', $fill))->highlight(key($this->parts)) . (string) $currentProgressBar;
        }

        return $currentProgressBar;
    }

    public function render($size, array $parts)
    {
        $this->calculateTotal($parts);
        $this->size = $size;
        $this->parts = $parts;

        $c = new Color();
        $r = '';

        foreach ($parts as $color => $x) {
            $bars = $this->valueToBars($x);
            $r .= $c(str_repeat(' ', $bars))->highlight($color);
        }

        $r = $this->fillToSize($r, $c);

        return $r;
    }
}
