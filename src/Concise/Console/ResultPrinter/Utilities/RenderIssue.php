<?php

namespace Concise\Console\ResultPrinter\Utilities;

use PHPUnit_Framework_Test;

class RenderIssue
{
    public function render($issueNumber, PHPUnit_Framework_Test $test)
    {
        return "$issueNumber. " . get_class($test);
    }
}
