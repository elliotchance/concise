<?php

namespace Concise\Console\ResultPrinter\Utilities;

class FilePathSimplifier
{
    public function process($filePath)
    {
        $cwd = getcwd();
        if (substr($filePath, 0, strlen($cwd)) === $cwd) {
            return substr($filePath, strlen($cwd) + 1);
        }

        return $filePath;
    }
}
