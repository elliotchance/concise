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

        foreach ($trace as $line) {
            if (!array_key_exists('line', $line)) {
                $line['line'] = '?';
            }

            $path = $this->getFile($line);
            if ($path == 'bin/concise' || substr($path, 0, 7) == 'vendor/') {
                continue;
            }
            $message .= $path;
            $message .= "    Line {$line['line']}: ";
        }

        return $message;
    }
}
