<?php

namespace Concise\Console\ResultPrinter\Utilities;

class TraceSimplifier
{
    public function render(array $trace)
    {
        if ($trace) {
            $simplifier = new FilePathSimplifier();

            return $simplifier->process($trace[0]['file']);
        }
    }
}
