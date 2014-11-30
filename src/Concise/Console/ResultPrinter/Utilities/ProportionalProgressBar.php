<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\Validation\ArgumentChecker;

class ProportionalProgressBar extends ProgressBar
{
    /**
     * @param integer $size
     * @param integer $total
     */
    public function renderProportional($size, $total, array $parts)
    {
        ArgumentChecker::check($size, 'integer');
        ArgumentChecker::check($total, 'integer', 2);

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
