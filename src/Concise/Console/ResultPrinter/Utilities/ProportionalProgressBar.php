<?php

namespace Concise\Console\ResultPrinter\Utilities;

class ProportionalProgressBar extends ProgressBar
{
    public function renderProportional($size, $total, array $parts)
    {
        $this->calculateTotal($parts);
        $barSize = $size * $this->total / $total;
        $bar = parent::render($barSize, $parts);
        $spaces = $size - substr_count($bar, ' ');

        return $bar . str_repeat('_', $spaces);
    }
}
