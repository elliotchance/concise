<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\Validation\ArgumentChecker;

class FilePathSimplifier
{
    /**
	 * @param  string $filePath
	 * @return string
	 */
    public function process($filePath)
    {
        ArgumentChecker::check($filePath, 'string', 1);

        $cwd = getcwd();
        if (substr($filePath, 0, strlen($cwd)) === $cwd) {
            return substr($filePath, strlen($cwd) + 1);
        }

        return $filePath;
    }
}
