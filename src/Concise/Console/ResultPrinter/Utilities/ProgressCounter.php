<?php

namespace Concise\Console\ResultPrinter\Utilities;

class ProgressCounter
{
    protected $total;

    protected $showPercentage;

    public function __construct($total, $showPercentage = false)
    {
        $this->total = $total;
        $this->showPercentage = $showPercentage;
    }

    public function render($value = 0)
    {
        return $value . ' / ' . $this->total . ($this->showPercentage ? ' (100%)' : '');
    }
}
