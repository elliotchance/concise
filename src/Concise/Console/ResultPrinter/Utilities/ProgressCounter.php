<?php

namespace Concise\Console\ResultPrinter\Utilities;

class ProgressCounter
{
    protected $total;

    public function __construct($total)
    {
        $this->total = $total;
    }

    public function render()
    {
        return '0 / ' . $this->total;
    }
}
