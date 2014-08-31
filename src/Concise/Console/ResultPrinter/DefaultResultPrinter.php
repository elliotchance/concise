<?php

namespace Concise\Console\ResultPrinter;

class DefaultResultPrinter extends AbstractResultPrinter
{
    protected $width;

    public function __construct()
    {
        $this->width = exec('tput cols');
    }

    public function end()
    {
        $this->write("\n\n\n");
    }
}
