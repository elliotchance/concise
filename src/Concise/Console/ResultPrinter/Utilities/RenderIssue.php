<?php

namespace Concise\Console\ResultPrinter\Utilities;

use PHPUnit_Framework_TestCase;

class RenderIssue
{
    public function render($issueNumber, PHPUnit_Framework_TestCase $test)
    {
        return "$issueNumber. " . get_class($test) . '::' . $test->getName();
    }
}
