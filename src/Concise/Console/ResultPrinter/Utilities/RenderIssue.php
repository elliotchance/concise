<?php

namespace Concise\Console\ResultPrinter\Utilities;

use PHPUnit_Framework_TestCase;
use Exception;

class RenderIssue
{
    protected $traceSimplifier;

    public function __construct(TraceSimplifier $traceSimplifier = null)
    {
        if (!$traceSimplifier) {
            $traceSimplifier = new TraceSimplifier();
        }
        $this->traceSimplifier = $traceSimplifier;
    }

    protected function prefixLines($prefix, $lines)
    {
        return $prefix . str_replace("\n", "\n$prefix", $lines);
    }

    public function render($issueNumber, PHPUnit_Framework_TestCase $test, Exception $e)
    {
        $message = "$issueNumber. " . get_class($test) . '::' . $test->getName() . "\n";
        $message .= " " . $e->getMessage() . "\n\n";
        $message .= $this->prefixLines("\033[90m", $this->traceSimplifier->render($e->getTrace())) . "\033[0m";

        return $message;
    }
}
