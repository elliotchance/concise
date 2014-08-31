<?php

namespace Concise\Console\ResultPrinter\Utilities;

class TraceSimplifier
{
    public function render(array $trace)
    {
        $simplifier = new FilePathSimplifier();
        $message = '';

        foreach ($trace as $line) {
            $path = $simplifier->process($line['file']);
            if ($path == 'bin/concise') {
                continue;
            }
            $message .= $simplifier->process($line['file']);
        }

        return $message;
    }
}
