<?php

namespace Concise\Console;

class ResultPrinter extends AbstractResultPrinter
{
    public function finish()
    {
        $this->write("\n\n\n");
    }
}
