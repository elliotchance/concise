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

    public function render($issueNumber, PHPUnit_Framework_TestCase $test, Exception $e)
    {
        $message = "$issueNumber. " . get_class($test) . '::' . $test->getName() . "\n";
        $message .= " " . $e->getMessage() . "\n\n";
        $message .= "\033[90m" . $this->traceSimplifier->render($e->getTrace());

        return $message;
    }
}
