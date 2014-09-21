<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\Validation\ArgumentChecker;

class ProportionalProgressBar extends ProgressBar
{
    public function renderProportional($size, $total, array $parts)
    {
        ArgumentChecker::check($size, 'integer');

        $this->calculateTotal($parts);
        if (0 === $total) {
            $total = $this->total;
        }
        if (0 === $total) {
            return str_repeat('_', $size);
        }
        $barSize = $size * $this->total / $total;
        $bar = parent::render((int) $barSize, $parts);
        $spaces = $size - substr_count($bar, ' ');

        return $bar . str_repeat('_', $spaces);
    }
}
