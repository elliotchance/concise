<?php

namespace Concise\Console\ResultPrinter\Utilities;

class TraceSimplifier
{
    public function render(array $trace)
    {
        $simplifier = new FilePathSimplifier();
        $message = '';

        foreach ($trace as $line) {
            if (!array_key_exists('file', $line)) {
                $line['file'] = '(unknown file)';
            }

            $path = $simplifier->process($line['file']);
            if ($path == 'bin/concise' || substr($path, 0, 7) == 'vendor/') {
                continue;
            }
            $message .= $simplifier->process($line['file']);
        }

        return $message;
    }
}
