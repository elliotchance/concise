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
        $r = $value . ' / ' . $this->total;
        if ($this->showPercentage) {
            $r .= sprintf(' (%3s%%)', floor($value / $this->total * 100));
        }

        return $r;
    }
}
