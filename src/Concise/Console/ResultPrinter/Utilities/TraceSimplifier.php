<?php

namespace Concise\Console\ResultPrinter\Utilities;

class TraceSimplifier
{
    protected $simplifier;

    protected $lastFile;

    protected $message;

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

    protected function init()
    {
        $this->message = '';
        $this->lastFile = '';
    }

    protected function shouldSkipPath($path)
    {
        return $path == 'bin/concise' || substr($path, 0, 7) == 'vendor/';
    }

    protected function getLineNumber(array $line)
    {
        if (!array_key_exists('line', $line)) {
            $line['line'] = '?';
        }

        return $line['line'];
    }

    protected function renderLine(array $line)
    {
        $line['line'] = $this->getLineNumber($line);

        $path = $this->getFile($line);
        if ($this->shouldSkipPath($path)) {
            return;
        }
        if ($this->lastFile != $path) {
            $this->message .= "$path\n";
        }
        $this->message .= "    Line {$line['line']}: {$line['function']}()\n";
        $this->lastFile = $path;
    }

    public function render(array $trace)
    {
        $this->init();
        foreach ($trace as $line) {
            $this->renderLine($line);
        }

        return $this->message;
    }
}
