<?php

namespace Concise\Console\ResultPrinter;

class DefaultResultPrinter extends AbstractResultPrinter
{
    public function end()
    {
        $this->write("\n\n\n");
    }
}
