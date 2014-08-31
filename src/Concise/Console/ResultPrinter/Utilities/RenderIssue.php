<?php

namespace Concise\Console\ResultPrinter\Utilities;

use PHPUnit_Framework_TestCase;
use Exception;

class RenderIssue
{
    public function render($issueNumber, PHPUnit_Framework_TestCase $test, Exception $e)
    {
        $message = "$issueNumber. " . get_class($test) . '::' . $test->getName() . "\n";
        $message .= " " . $e->getMessage() . "\n\n";

        return $message;
    }
}
