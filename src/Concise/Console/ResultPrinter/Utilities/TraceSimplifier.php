<?php

namespace Concise\Console\ResultPrinter\Utilities;

class TraceSimplifier
{
    protected $simplifier;

    public function __construct()
    {
        $this->simplifier = new FilePathSimplifier();
    }

    protected function getFile(array $line)
    {
        if (!array_key_exists('file', $line)) {
            $line['file'] = '(unknown file)';
        }

        return $this->simplifier->process($line['file']);
    }

    public function render(array $trace)
    {
        $message = '';
        $lastFile = '';

        foreach ($trace as $line) {
            if (!array_key_exists('line', $line)) {
                $line['line'] = '?';
            }

            $path = $this->getFile($line);
            if ($path == 'bin/concise' || substr($path, 0, 7) == 'vendor/') {
                continue;
            }
            if ($lastFile != $path) {
                $message .= "$path\n";
            }
            $message .= "    Line {$line['line']}: ";
            $lastFile = $path;
        }

        return $message;
    }
}
