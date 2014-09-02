<?php

namespace Concise\Console\ResultPrinter\Utilities;

use DomainException;

class ProgressCounter
{
    protected $total;

    protected $showPercentage;

    public function __construct($total, $showPercentage = false)
    {
        if ($total < 0) {
            throw new DomainException("Total must be at least zero.");
        }

        $this->total = $total;
        $this->showPercentage = $showPercentage;
    }

    public function render($value = 0)
    {
        $r = $value . ' / ' . $this->total;
        if ($this->showPercentage) {
            $percentage = (0 === $this->total) ? 0 : floor($value / $this->total * 100);
            $r .= sprintf(' (%3s%%)', $percentage);
        }

        return $r;
    }
}
